<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditDocument;
use App\Http\Requests\EditProduct;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\StoreInventory;
use App\Http\Requests\StoreProduct;
use App\Models\Document;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;
use Auth;

class InventoriesController extends Controller
{
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function inventories(Request $request)
    {
        $pages       = $request->get('pages', 10);
        $inventories = Inventory::sortable()->paginate($pages);

        return view('product/inventory/inventories', ['inventories' => $inventories]);
    }

    public function newInventory(Request $request)
    {
        $providers = Provider::pluck('name', 'id');
        $providers->prepend('', '');

        return view('product/inventory/new', ['providers' => $providers]);
    }

    public function storeInventory(StoreInventory $request)
    {
        $userId = Auth::id();

        Inventory::create([
            'user_id'     => $userId,
            'provider_id' => $request->get('provider'),
            'product_id'  => $request->get('product'),
            'cost_id'     => $request->get('cost'),
            'initial'     => $request->get('quantity'),
            'entry'       => 0,
            'output'      => 0,
            'current'     => $request->get('quantity'),
        ]);

        return redirect('product/inventories')->with([
            'status' => 'Nuevo inventario agregado exitosamente'
        ]);
    }

    public function editInventory($id)
    {
        $inventory = Inventory::find($id);

        if ($inventory) {

            return view('product/inventory/edit', ['document' => $inventory]);
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
