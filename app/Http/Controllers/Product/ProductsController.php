<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProduct;
use App\Http\Requests\StoreProduct;
use App\Models\Barcode;
use App\Models\Category;
use App\Models\Cost;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Provider;
use App\Models\ProviderProduct;
use Illuminate\Http\Request;
use File;
use Auth;
use Image;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function products(Request $request)
    {
        $pages    = $request->get('pages', 10);

        if ($request->has('search')) {
            $search = $request->get('search');
            $products = Product::with(['providers', 'categories'])->like('description', $search)->orderBy('created_at', 'DESC')->sortable()->paginate($pages);
        } else {
            $products = Product::with(['providers', 'categories'])->orderBy('created_at', 'DESC')->sortable()->paginate($pages);
        }

        return view('product/product/products', ['products' => $products]);
    }

    public function newProduct(Request $request)
    {
        $providers  = Provider::pluck('name', 'id');
        $categories = Category::pluck('description', 'id');

        return view('product/product/new', ['providers' => $providers, 'categories' => $categories]);
    }

    public function storeProduct(StoreProduct $request)
    {
        $userId        = Auth::id();
        $file          = $request->file('image');
        $extension     = $file->getClientOriginalExtension();
        $filename      = $this->fileGuid();
        $full_filename = $filename . '.' . $extension;
        $thumbnail     = $filename . '-thumb.' . $extension;

        $image = Image::make($file->getRealPath());
        $image->save(public_path('uploads/' . $full_filename));
        $image->fit(60, 60)->save(public_path('uploads/' . $thumbnail));

        $product = Product::create([
            'description'      => $request->get('description'),
            'image'            => $full_filename,
            'thumbnail'        => $thumbnail
        ]);

        $providers  = $request->get('provider');
        $categories = $request->get('category');

        $cost = Cost::create([
            'product_id'      => $product['id'],
            'unit_price'      => $request->get('unit_price'),
            'unit_cost'       => $request->get('unit_cost'),
            'wholesale_price' => $request->get('wholesale_price')
        ]);

        Inventory::create([
            'user_id'     => $userId,
            //'provider_id' => $providers[0],
            'product_id'  => $product['id'],
            'cost_id'     => $cost['id'],
            'initial'     => $request->get('quantity'),
            'entry'       => 0,
            'output'      => 0,
            'current'     => $request->get('quantity'),
        ]);

        $product->providers()->attach($providers);
        $product->categories()->attach($categories);

        $codes    = explode(',', $request->get('bar_code'));
        $barcodes = [];

        foreach ($codes as $code) {
            $barcodes[] = new Barcode([
                'code' => $code
            ]);
        }

        $product->barcodes()->saveMany($barcodes);

        return redirect('product/products')->with([
            'status' => 'Nuevo producto agregado exitosamente'
        ]);
    }

    private function fileGuid()
    {
        $s = strtoupper(md5(uniqid(rand(), true)));

        $guidText =
            substr($s, 0, 8) . '-' .
            substr($s, 8, 4) . '-' .
            substr($s, 12, 4) . '-' .
            substr($s, 16, 4) . '-' .
            substr($s, 20);

        return $guidText;
    }

    public function editProduct($id)
    {
        $product = Product::with(['providers', 'categories'])->find($id);

        if ($product) {
            $providers  = Provider::pluck('name', 'id');
            $categories = Category::pluck('description', 'id');

            return view('product/product/edit', [
                'product'    => $product,
                'providers'  => $providers,
                'categories' => $categories
            ]);
        }

        return response('', 404);
    }

    public function saveEditProduct(EditProduct $request, $id)
    {
        $product = Product::with(['providers', 'categories'])->find($id);

        if ($product) {

            if ($request->hasFile('image')) {
                $file          = $request->file('image');
                $extension     = $file->getClientOriginalExtension();
                $filename      = $this->fileGuid();
                $full_filename = $filename . '.' . $extension;
                $thumbnail     = $filename . '-thumb.' . $extension;

                $image = Image::make($file->getRealPath());
                $image->save(public_path('uploads/' . $full_filename));
                $image->fit(60, 60)->save(public_path('uploads/' . $thumbnail));

                File::Delete(public_path('uploads/' . $product->image));
                File::Delete(public_path('uploads/' . $product->thumbnail));

                $product->image     = $full_filename;
                $product->thumbnail = $thumbnail;
            }

            $product->description      = $request->get('description');

            $providers  = $request->get('provider');
            $categories = $request->get('category');

            $product->providers()->sync($providers);
            $product->categories()->sync($categories);

            $codes           = explode(',', $request->get('bar_code'));
            $barcodes        = [];
            $productBarcodes = $product->barcodes()->pluck('code')->toArray();

            foreach ($codes as $index => $code) {
                $barcode = Barcode::where('code', '=', $code)->where('product_id', '=', $product->id)->first();

                if ($barcode) {
                    $barcode->code = $code;
                    $barcode->save();
                } else {
                    $barcodes[] = new Barcode([
                        'code' => $code
                    ]);
                }

                if (in_array($code, $productBarcodes)) {
                    unset($productBarcodes[$index]);
                }

            }

            foreach ($productBarcodes as $code) {
                Barcode::where('code', '=', $code)->where('product_id', '=', $product->id)->delete();
            }

            $product->barcodes()->saveMany($barcodes);

            $productCost                  = $product->cost;
            $productCost->unit_price      = $request->get('unit_price');
            $productCost->unit_cost       = $request->get('unit_cost');
            $productCost->wholesale_price = $request->get('wholesale_price');
            $productCost->save();

            $product->save();

            return redirect('product/products')->with([
                'status' => 'Product actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteProduct($id)
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

            if (count($product->invoiceDetails) || count($product->movementDetails)) {

                $message = 'Este producto no puede ser eliminado ya que esta referenciado en ';

                $countMessage = [];

                if (count($product->invoiceDetails)) {
                    $invoicesCount = $product->invoiceDetails->count();
                    $countMessage[] = "$invoicesCount detalles de venta de mercaderia";
                }

                if (count($product->movementDetails)) {
                    $movementsCount = $product->movementDetails->count();
                    $countMessage[] = "$movementsCount detalles de movimientos";
                }

                $message .= implode(', ', $countMessage) . '.';

                return redirect("product/products/delete/{$product->id}")->with([
                    'error' => $message
                ]);

            } else {
                File::Delete(public_path('uploads/' . $product->image));
                File::Delete(public_path('uploads/' . $product->thumbnail));

                $product->delete();

                return redirect('product/products')->with([
                    'status' => 'Producto eliminado exitosamente'
                ]);
            }

        }

        return response('', 404);
    }
}
