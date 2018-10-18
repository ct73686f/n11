<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditCost;
use App\Http\Requests\StoreCost;
use App\Models\Cost;
use App\Models\Product;
use Illuminate\Http\Request;

class CostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function costs(Request $request)
    {
        $pages = $request->get('pages', 10);
        $costs = Cost::sortable()->paginate($pages);

        return view('product/cost/costs', ['costs' => $costs]);
    }

    public function newCost(Request $request)
    {
        $products = Product::pluck('description', 'id');

        return view('product/cost/new', ['products' => $products]);
    }

    public function storeCost(StoreCost $request)
    {
        Cost::create([
            'product_id'      => $request->get('product'),
            'unit_price'      => $request->get('unit_price'),
            'unit_cost'       => $request->get('unit_cost'),
            'wholesale_price' => $request->get('wholesale_price')
        ]);

        return redirect('product/costs')->with([
            'status' => 'Nueva costo agregado exitosamente'
        ]);
    }

    public function editCost($id)
    {
        $cost = Cost::find($id);

        if ($cost) {
            $products = Product::pluck('description', 'id');

            return view('product/cost/edit', ['cost' => $cost, 'products' => $products]);
        }

        return response('', 404);
    }

    public function saveEditCost(EditCost $request, $id)
    {
        $cost = Cost::find($id);

        if ($cost) {
            $cost->product_id      = $request->get('product');
            $cost->unit_price      = $request->get('unit_price');
            $cost->unit_cost       = $request->get('unit_cost');
            $cost->wholesale_price = $request->get('wholesale_price');
            $cost->save();

            return redirect('product/costs')->with([
                'status' => 'Costo actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteCost($id)
    {
        $cost = Cost::find($id);

        if ($cost) {
            return view('product/cost/delete', ['cost' => $cost]);
        }

        return response('', 404);
    }

    public function proceedDeleteCost($id)
    {
        $cost = Cost::find($id);

        if ($cost) {
            $cost->delete();

            return redirect('product/costs')->with([
                'status' => 'Costo eliminado exitosamente'
            ]);
        }

        return response('', 404);
    }
}
