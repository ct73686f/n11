<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditClient;
use App\Http\Requests\EditCost;
use App\Http\Requests\EditCreditType;
use App\Http\Requests\StoreClient;
use App\Http\Requests\StoreCost;
use App\Http\Requests\StoreCreditType;
use App\Models\Client;
use App\Models\Cost;
use App\Models\CreditType;
use App\Models\Product;
use Illuminate\Http\Request;

class CreditTypesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function creditTypes(Request $request)
    {
        $pages       = $request->get('pages', 10);
        $creditTypes = CreditType::sortable()->paginate($pages);

        return view('product/credit-type/credit-types', ['creditTypes' => $creditTypes]);
    }

    public function newCreditType(Request $request)
    {
        return view('product/credit-type/new');
    }

    public function storeCreditType(StoreCreditType $request)
    {
        CreditType::create([
            'description' => $request->get('description'),
            'term'        => $request->get('term'),
            'amount'      => $request->get('amount')
        ]);

        return redirect('product/credit-types')->with([
            'status' => 'Nueva tipo de credito agregado exitosamente'
        ]);
    }

    public function editCreditType($id)
    {
        $creditType = CreditType::find($id);

        if ($creditType) {
            return view('product/credit-type/edit', ['creditType' => $creditType]);
        }

        return response('', 404);
    }

    public function saveEditCreditType(EditCreditType $request, $id)
    {
        $creditType = CreditType::find($id);

        if ($creditType) {
            $creditType->description = $request->get('description');
            $creditType->term        = $request->get('term');
            $creditType->amount      = $request->get('amount');
            $creditType->save();

            return redirect('product/credit-types')->with([
                'status' => 'Tipo de credito actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteCreditType($id)
    {
        $creditTYpe = CreditType::find($id);

        if ($creditTYpe) {
            return view('product/credit-type/delete', ['creditType' => $creditTYpe]);
        }

        return response('', 404);
    }

    public function proceedDeleteCreditType($id)
    {
        $creditType = CreditType::find($id);

        if ($creditType) {
            $creditType->delete();

            return redirect('product/credit-types')->with([
                'status' => 'Tipo de credito eliminado exitosamente'
            ]);
        }

        return response('', 404);
    }
}
