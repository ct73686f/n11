<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditDocument;
use App\Http\Requests\GetMovementProduct;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\StoreMovement;
use App\Http\Requests\StoreMovementCash;
use App\Models\Cost;
use App\Models\Document;
use App\Models\DocumentCash;
use App\Models\Inventory;
use App\Models\Movement;
use App\Models\MovementCash;
use App\Models\MovementDetail;
use App\Models\Product;
use App\Models\Provider;
use App\Models\StoreCash;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Auth;
use PDF;

class MovementsCashController extends Controller
{
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $guard)
    {
        $this->auth = $guard->user();
    }

    public function movements(Request $request)
    {
        $pages     = $request->get('pages', 10);
        $movements = MovementCash::sortable()->paginate($pages);

        return view('product/movement-cash/movements', ['movements' => $movements]);
    }

    public function newMovement(Request $request)
    {
        $documents = DocumentCash::pluck('description', 'id');
        $documents->prepend('', '');

        return view('product/movement-cash/new', ['documents' => $documents]);
    }

    public function getMovementProduct(GetMovementProduct $request)
    {
        $product    = Product::find($request->get('product'));
        $outputType = $request->get('output_type');

        $quantity = $request->get('quantity');
        $subTotal = $quantity * $product->cost->unit_price;

        if ($outputType == 'E') {
            $subTotal = $quantity * $product->cost->unit_cost;
        }

        return response()->json([
            'view'      => view('product/movement/get-product',
                ['product' => $product, 'quantity' => $quantity, 'subTotal' => $subTotal])->render(),
            'sub_total' => $subTotal
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function storeMovement(StoreMovementCash $request)
    {
        $document         = $request->get('document');
        $description      = $request->get('description');
        $amount           = $request->get('amount');
        $documentMovement = DocumentCash::find($document);
        $outputType       = $documentMovement->raw_output_type;

        $today     = date('Y-m-d');
        $storeCash = StoreCash::whereDate('created_at', '=', $today)->first();

        if ($outputType == 'E') {

            if ($storeCash) {
                $total             = $storeCash->amount;
                $storeCash->amount = ($amount + $total);
                $storeCash->save();
            } else {
                StoreCash::create([
                    'amount' => $amount
                ]);
            }
        } else {
            if ($storeCash) {
                $total             = $storeCash->amount;
                $totalStoreCash = ($total - $amount);

                $storeCash->amount = $totalStoreCash;
                $storeCash->save();
            }
        }

        MovementCash::create([
            'document_cash_id' => $document,
            'description'      => $description,
            'amount'           => $amount
        ]);

        return redirect('product/movements-cash')->with([
            'status' => 'Nuevo movimiento efectivo agregado exitosamente'
        ]);
    }

    public function viewMovement($id)
    {
        $movement = Movement::find($id);

        if ($movement) {
            return view('product/movement/view', ['movement' => $movement]);
        }

        return response('', 404);
    }

    public function viewMovementPDF($id)
    {
        $movement = Movement::find($id);

        if ($movement) {
            $pdf = PDF::loadView('product/movement/pdf', ['movement' => $movement]);
            return $pdf->stream("movimiento-$movement->id.pdf");
        }

        return response('', 404);
    }

    public function editMovement($id)
    {
        $document = Document::find($id);

        if ($document) {

            return view('product/document/edit', ['document' => $document]);
        }

        return response('', 404);
    }

    public function saveEditDocument(EditDocument $request, $id)
    {
        $document = Document::find($id);

        if ($document) {
            $document->description = $request->get('description');
            $document->output_type = $request->get('output_type');
            $document->save();

            return redirect('product/documents')->with([
                'status' => 'Documento actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteDocument($id)
    {
        $product = Product::find($id);

        if ($product) {
            return view('product/product/delete', ['product' => $product]);
        }

        return response('', 404);
    }

    public function proceedDeleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            File::Delete(public_path('uploads/' . $product->image));
            File::Delete(public_path('uploads/' . $product->thumbnail));

            $product->delete();

            return redirect('product/products')->with([
                'status' => 'Producto eliminado exitosamente'
            ]);
        }

        return response('', 404);
    }
}
