<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditClient;
use App\Http\Requests\EditCost;
use App\Http\Requests\EditCreditType;
use App\Http\Requests\EditPaymentMethod;
use App\Http\Requests\StoreClient;
use App\Http\Requests\StoreCost;
use App\Http\Requests\StoreCreditType;
use App\Http\Requests\StorePaymentMethod;
use App\Models\Client;
use App\Models\Cost;
use App\Models\CreditType;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;

class PaymentMethodsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function paymentMethods(Request $request)
    {
        $pages       = $request->get('pages', 10);
        $paymentMethods = PaymentMethod::sortable()->paginate($pages);

        return view('product/payment-method/payment-methods', ['paymentMethods' => $paymentMethods]);
    }

    public function newPaymentMethod(Request $request)
    {
        return view('product/payment-method/new');
    }

    public function storePaymentMethod(StorePaymentMethod $request)
    {
        PaymentMethod::create([
            'description' => $request->get('description')
        ]);

        return redirect('product/payment-methods')->with([
            'status' => 'Nuevo medio de pago agregado exitosamente'
        ]);
    }

    public function editPaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if ($paymentMethod) {
            return view('product/payment-method/edit', ['paymentMethod' => $paymentMethod]);
        }

        return response('', 404);
    }

    public function saveEditPaymentMethod(EditPaymentMethod $request, $id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if ($paymentMethod) {
            $paymentMethod->description = $request->get('description');
            $paymentMethod->save();

            return redirect('product/payment-methods')->with([
                'status' => 'Medio de pago actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deletePaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if ($paymentMethod) {
            return view('product/payment-method/delete', ['paymentMethod' => $paymentMethod]);
        }

        return response('', 404);
    }

    public function proceedDeletePaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if ($paymentMethod) {
            $paymentMethod->delete();

            return redirect('product/payment-methods')->with([
                'status' => 'Medio de pago eliminado exitosamente'
            ]);
        }

        return response('', 404);
    }
}
