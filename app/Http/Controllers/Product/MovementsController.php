<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditDocument;
use App\Http\Requests\GetMovementProduct;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\StoreMovement;
use App\Models\Cost;
use App\Models\Document;
use App\Models\Inventory;
use App\Models\Movement;
use App\Models\MovementDetail;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Auth;
use PDF;

class MovementsController extends Controller
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
        $movements = Movement::sortable()->orderBy('created_at', 'DESC')->paginate($pages);

        return view('product/movement/movements', ['movements' => $movements]);
    }

    public function newMovement(Request $request)
    {
        $documents = Document::pluck('description', 'id');
        $documents->prepend('', '');
        $products = Product::all();

        return view('product/movement/new', ['documents' => $documents, 'products' => $products]);
    }

    public function getMovementProduct(GetMovementProduct $request)
    {
        $product  = Product::find($request->get('product'));
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

    public function storeMovement(StoreMovement $request)
    {
        $userID        = Auth::id();
        $document      = $request->get('document');
        $products      = $request->get('product');
        $quantities    = $request->get('quantity');
        $invoiceNumber = $request->get('invoice_number');
        //$costs         = $request->get('cost');
        $totalMovement = 0;

        $documentMovement = Document::find($document);
        $outputType       = $documentMovement->raw_output_type;

        $movement = Movement::create([
            'user_id'        => $userID,
            'document_id'    => $document,
            'invoice_number' => $invoiceNumber,
            'total'          => 0
        ]);

        foreach ($products as $index => $productId) {
            $product = Product::find($productId);

            if ($product) {
                $cost     = $product->cost->unit_cost;
                $price    = $product->cost->unit_price;
                $quantity = $quantities[$index];

                $total = ($price * $quantity);

                if ($outputType == 'E') {
                    //$cost = $costs[$index];
                    $price = $cost;
                }

                $totalMovement += $total;


                MovementDetail::create([
                    'movement_id' => $movement['id'],
                    'user_id'     => $userID,
                    'document_id' => $document,
                    'product_id'  => $productId,
                    'cost_id'     => $product->cost->id,
                    'quantity'    => $quantity,
                    'price'       => $price,
                    'cost'        => $cost,
                ]);

                $productInventory = Inventory::where('product_id', '=', $productId)->first();
                $additionTotal    = 0;
                $substractTotal   = 0;
                $currentTotal     = 0;

                if ($outputType == 'E') {
                    $initialTotal   = $productInventory->initial;
                    $entryTotal     = $productInventory->entry;
                    $additionTotal  = ($entryTotal + $quantity);
                    $outputTotal    = $productInventory->output;
                    $substractTotal = $outputTotal;
                    $currentTotal   = (($initialTotal + $additionTotal) - ($substractTotal));
                } elseif ($outputType == 'S') {
                    $initialTotal   = $productInventory->initial;
                    $entryTotal     = $productInventory->entry;
                    $additionTotal  = $entryTotal;
                    $outputTotal    = $productInventory->output;
                    $substractTotal = ($outputTotal + $quantity);
                    $currentTotal   = (($initialTotal + $additionTotal) - ($substractTotal));
                }

                $productInventory->entry   = $additionTotal;
                $productInventory->output  = $substractTotal;
                $productInventory->current = $currentTotal;
                $productInventory->save();
            }
        }

        $movement->total = $totalMovement;
        $movement->save();

        $request->session()->flash('status', 'Nuevo movimiento agregado exitosamente');

        return response()->json([], 200, [], JSON_UNESCAPED_UNICODE);
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
