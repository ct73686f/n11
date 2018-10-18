<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditAccountsReceivable;
use App\Http\Requests\EditDebt;
use App\Http\Requests\EditInvoice;
use App\Http\Requests\GetInvoiceProduct;
use App\Http\Requests\StoreAccountsReceivable;
use App\Http\Requests\StoreDebt;
use App\Http\Requests\StoreInvoice;
use App\Models\AccountsReceivable;
use App\Models\Client;
use App\Models\ClientCredit;
use App\Models\Cost;
use App\Models\CreditType;
use App\Models\Debt;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use PDF;

class DebtsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function debts(Request $request)
    {
        $pages = $request->get('pages', 10);
        $debts = Debt::sortable()->paginate($pages);

        return view('product/debt/debts',
            ['debts' => $debts]);
    }

    public function newDebt(Request $request)
    {
        $providers = Provider::get()->pluck('name', 'id');
        $providers->prepend('', '');

        return view('product/debt/new', ['providers' => $providers]);
    }

    public function viewInvoice($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            return view('product/invoice/view', ['invoice' => $invoice]);
        }

        return response('', 404);
    }

    public function storeDebt(StoreDebt $request)
    {
        $provider = Provider::find($request->get('provider'));


        $status      = $request->get('status');
        $paymentDate = $request->get('payment_date');//date('Y/m/d');
        $amount      = $request->get('amount');

        Debt::create([
            'provider_id'  => $provider->id,
            'payment_date' => $paymentDate,
            'amount'       => $amount,
            'status'       => $status
        ]);

        return redirect('product/debts')->with([
            'status' => 'Nueva cuenta por pagar agregada exitosamente'
        ]);
    }

    public function editDebt($id)
    {
        $debt = Debt::find($id);

        if ($debt) {
            return view('product/debt/edit', ['debt' => $debt]);
        }

        return response('', 404);
    }

    public function saveEditDebt(EditDebt $request, $id)
    {
        $debt = Debt::find($id);

        if ($debt) {
            $status = $request->get('status');

            $debt->payment_date = $request->get('payment_date');
            $debt->status       = $status;
            $debt->save();

            return redirect('product/debts')->with([
                'status' => 'Cuenta por pagar actualizada exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteDebt($id)
    {
        $debt = Debt::find($id);

        if ($debt) {
            return view('product/debt/delete', ['debt' => $debt]);
        }

        return response('', 404);
    }

    public function proceedDeleteDebt($id)
    {
        $debt = Debt::find($id);

        if ($debt) {
            $debt->delete();

            return redirect('product/debts')->with([
                'status' => 'Cuenta por pagar eliminada exitosamente'
            ]);
        }

        return response('', 404);
    }
}
