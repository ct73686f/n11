<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditAccountsReceivable;
use App\Http\Requests\EditInvoice;
use App\Http\Requests\GetInvoiceProduct;
use App\Http\Requests\StoreAccountsReceivable;
use App\Http\Requests\StoreInvoice;
use App\Models\AccountsReceivable;
use App\Models\Client;
use App\Models\ClientCredit;
use App\Models\Cost;
use App\Models\CreditType;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\PaymentMethod;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use PDF;

class AccountsReceivablesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function accountsReceivables(Request $request)
    {
        $pages               = $request->get('pages', 10);
        $accountsReceivables = AccountsReceivable::sortable()->paginate($pages);

        return view('product/accounts-receivable/accounts-receivables',
            ['accountsReceivables' => $accountsReceivables]);
    }

    public function newAccountsReceivable(Request $request)
    {
        $clients = Client::get()->pluck('full_name', 'id');
        $clients->prepend('', '');

        $invoices = Invoice::get()->pluck('invoice_number', 'id');
        $invoices->prepend('', '');

        $products = Product::pluck('description', 'id');

        return view('product/accounts-receivable/new', ['invoices' => $invoices, 'products' => $products]);
    }

    public function viewInvoice($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            return view('product/invoice/view', ['invoice' => $invoice]);
        }

        return response('', 404);
    }

    public function storeAccountsReceivable(StoreAccountsReceivable $request)
    {
        $invoice = Invoice::find($request->get('invoice'));

        $credit = CreditType::create([
            'description' => '',
            'term'        => 0,//$request->get('term'),
            'amount'      => $request->get('amount')
        ]);

        $invoiceTotal = $invoice->total - $invoice->discount;
        $status       = $request->get('status');
        $paymentDate  = $request->get('payment_date');//date('Y/m/d');

        AccountsReceivable::create([
            'invoice_id'     => $invoice->id,
            'client_id'      => $invoice->client->id,
            'credit_type_id' => $credit['id'],
            'payment_date'   => $paymentDate,
            'total'          => $invoiceTotal,
            'status'         => $status
        ]);

        return redirect('product/accounts-receivables')->with([
            'status' => 'Nueva cuenta por cobrar agregada exitosamente'
        ]);
    }



    public function editAccountsReceivable($id)
    {
        $accountsReceivable = AccountsReceivable::find($id);

        if ($accountsReceivable) {
            return view('product/accounts-receivable/edit', ['accountsReceivable' => $accountsReceivable]);
        }

        return response('', 404);
    }

    public function saveEditAccountsReceivable(EditAccountsReceivable $request, $id)
    {
        $accountsReceivable = AccountsReceivable::find($id);

        if ($accountsReceivable) {
            /*$paymentMethod              = $accountsReceivable->paymentMethod;
            $paymentMethod->description = $request->get('payment_method');
            $paymentMethod->save();*/

            $creditType = $accountsReceivable->creditType;
            //$creditType->term        = $request->get('term');
            $creditType->amount = $request->get('amount');
            $creditType->save();

            /*$clientCredit             = $accountsReceivable->client->credit;
            $clientCredit->start_date = $request->get('start_date');
            $clientCredit->end_date   = $request->get('end_date');
            $clientCredit->amount     = $request->get('total');
            $clientCredit->save();*/

            /*$accountsReceivable->nit         = $request->get('nit');
            $accountsReceivable->description = $request->get('description');
            $accountsReceivable->total       = $request->get('total');*/
            $status = $request->get('status');

            /*if ($status == 'Y') {
                $accountsReceivable->payment_date = date('Y/m/d');
            }*/

            $accountsReceivable->payment_date = $request->get('payment_date');
            $accountsReceivable->status       = $status;
            $accountsReceivable->save();

            return redirect('product/accounts-receivables')->with([
                'status' => 'Cuenta por cobrar actualizada exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteAccountsReceivable($id)
    {
        $accountsReceivable = AccountsReceivable::find($id);

        if ($accountsReceivable) {
            return view('product/accounts-receivable/delete', ['accountsReceivable' => $accountsReceivable]);
        }

        return response('', 404);
    }

    public function proceedDeleteAccountsReceivable($id)
    {
        $accountsReceivable = AccountsReceivable::find($id);

        if ($accountsReceivable) {
            $accountsReceivable->delete();

            return redirect('product/accounts-receivables')->with([
                'status' => 'Cuenta por cobrar eliminada exitosamente'
            ]);
        }

        return response('', 404);
    }
}
