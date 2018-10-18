<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditInvoice;
use App\Http\Requests\GetInvoiceProduct;
use App\Http\Requests\StoreInvoice;
use App\Http\Requests\StoreQuotation;
use App\Models\Client;
use App\Models\ClientCredit;
use App\Models\Cost;
use App\Models\CreditType;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\QuotationPaymentMethod;
use Illuminate\Http\Request;
use Auth;
use mPDF;
use PDF;

class QuotationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function quotations(Request $request)
    {
        $pages      = $request->get('pages', 10);
        $quotations = Quotation::sortable()->orderBy('id', 'DESC')->paginate($pages);

        return view('product/quotation/quotations', ['quotations' => $quotations]);
    }

    public function newQuotation(Request $request)
    {
        $clients = Client::get()->pluck('full_name', 'id');
        $clients->prepend('', '');
        $products = Product::all();

        return view('product/quotation/new', ['clients' => $clients, 'products' => $products]);
    }

    public function getQuotationProduct(GetInvoiceProduct $request)
    {
        $product   = Product::find($request->get('product'));
        $quantity  = $request->get('quantity');
        $wholesale = $request->get('wholesale');

        if ($wholesale == 'Y') {
            $subTotal = $quantity * $product->cost->wholesale_price;
        } else {
            $subTotal = $quantity * $product->cost->unit_price;
        }


        return response()->json([
            'view'      => view('product/invoice/get-product',
                ['product' => $product, 'quantity' => $quantity, 'subTotal' => $subTotal])->render(),
            'sub_total' => $subTotal
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getQuotationProductTotal(Request $request)
    {
        $id           = $request->get('id');
        $total        = $request->get('total');
        $totalCurrent = $request->get('total_current');
        $product      = Product::find($id);

        if ($product) {
            $inventory           = $product->inventory;
            $productTotal        = ($inventory->current - $total);
            $productTotalCurrent = ($inventory->current - $totalCurrent);

            if ($productTotal < 0) {
                return [
                    'valid'    => false,
                    'quantity' => "No hay suficiente producto disponible para completar la cantidad solicitda. Producto disponible: {$productTotalCurrent}"
                ];
            } else {
                return ['valid' => true];
            }
        }

        return ['valid' => false, 'quantity' => 'Producto no encontrado'];
    }

    public function viewQuotation($id)
    {
        $quotation = Quotation::find($id);

        if ($quotation) {
            return view('product/quotation/view', ['quotation' => $quotation]);
        }

        return response('', 404);
    }

    public function storeQuotation(StoreQuotation $request)
    {
        $userId            = Auth::id();
        $products          = $request->get('product');
        $quantities        = $request->get('quantity');
        $nit               = $request->get('nit');
        $clientName        = $request->get('client');
        $wholesale_applies = $request->get('wholesale_apply');
        $client            = 0;
        $clientInvoice     = Client::where('nit', '=', $nit)->first();
        $wholesale_apply   = $request->get('wholesale_apply');

        $discount = 0;

        if ($request->has('discount')) {
            $discount = $request->get('discount');
        }

        if (!$clientInvoice) {
            $newClient = Client::create([
                'first_name' => $clientName,
                'last_name'  => '',
                'address'    => '',
                'nit'        => $nit,
                'phone'      => ''
            ]);

            $client = $newClient['id'];
        } else {
            $client = $clientInvoice->id;
        }

        $quotation = Quotation::create([
            'user_id'     => $userId,
            'client_id'   => $client,
            'nit'         => $nit,
            'description' => $request->get('description'),
            'discount'    => $discount,
            'surcharge'   => 0,
            'total'       => 0
        ]);

        $credit  = $request->get('credit');
        $cash    = $request->get('cash');
        $card    = $request->get('card');
        $check   = $request->get('check');
        $deposit = $request->get('deposit');

        if ($credit) {
            QuotationPaymentMethod::create([
                'quotation_id' => $quotation['id'],
                'description'  => 'Credito',
                'amount'       => $credit
            ]);
        }

        if ($cash) {
            QuotationPaymentMethod::create([
                'quotation_id' => $quotation['id'],
                'description'  => 'Efectivo',
                'amount'       => $cash
            ]);

        }

        if ($card) {
            QuotationPaymentMethod::create([
                'quotation_id' => $quotation['id'],
                'description'  => 'Tarjeta',
                'amount'       => $card
            ]);
        }

        if ($check) {
            QuotationPaymentMethod::create([
                'quotation_id' => $quotation['id'],
                'description'  => 'Cheque',
                'amount'       => $check
            ]);
        }

        if ($deposit) {
            QuotationPaymentMethod::create([
                'quotation_id' => $quotation['id'],
                'description'  => 'Deposito',
                'amount'       => $deposit
            ]);
        }

        $totalInvoice = 0;
        $surcharge    = $request->get('surcharge');

        if (!is_numeric($surcharge)) {
            $surcharge = 0;
        }

        foreach ($products as $index => $productId) {
            $product         = Product::find($productId);
            $cost            = $product->cost->unit_cost;
            $quantity        = $quantities[$index];
            $price           = $product->cost->unit_price;
            $wholesale_apply = $wholesale_applies[$index];

            if ($wholesale_apply == 'Y') {
                $price = $product->cost->wholesale_price;
            }

            $total        = ($price * $quantity);
            $totalInvoice += $total;

            QuotationDetail::create([
                'quotation_id' => $quotation['id'],
                'product_id'   => $productId,
                'cost_id'      => $product->cost->id,
                'quantity'     => $quantity,
                'unit_price'   => $price,
                'unit_cost'    => $cost,
                'sub_total'    => $total,
            ]);
        }

        // Update invoice total and Client credit amount
        $quotation->surcharge = $surcharge;
        $quotation->total     = $totalInvoice;
        $quotation->save();


        //$request->session()->flash('status', 'Nueva factura agregada exitosamente');

        return response()->json(['url' => url('product/quotations/pdf', ['id' => $quotation['id']])], 200, [],
            JSON_UNESCAPED_UNICODE);
    }

    public function editQuotation($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            $clients = Client::get()->pluck('full_name', 'id');

            return view('product/invoice/edit', ['invoice' => $invoice, 'clients' => $clients]);
        }

        return response('', 404);
    }

    public function saveEditQuotation(EditInvoice $request, $id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            $paymentMethod              = $invoice->paymentMethod;
            $paymentMethod->description = $request->get('payment_method');
            $paymentMethod->save();

            $creditType              = $invoice->creditType;
            $creditType->description = $request->get('credit_type');
            $creditType->term        = $request->get('term');
            $creditType->amount      = $request->get('amount');
            $creditType->save();

            $clientCredit             = $invoice->client->credit;
            $clientCredit->start_date = $request->get('start_date');
            $clientCredit->end_date   = $request->get('end_date');
            $clientCredit->amount     = $request->get('total');
            $clientCredit->save();

            $invoice->nit         = $request->get('nit');
            $invoice->description = $request->get('description');
            $invoice->total       = $request->get('total');

            $invoice->save();

            return redirect('product/invoices')->with([
                'status' => 'Factura actualizada exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteQuotation($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            return view('product/invoice/delete', ['invoice' => $invoice]);
        }

        return response('', 404);
    }

    public function proceedDeleteQuotation($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            $invoice->delete();

            return redirect('product/invoices')->with([
                'status' => 'Factura eliminada exitosamente'
            ]);
        }

        return response('', 404);
    }

    public function viewQuotationPDF($id)
    {
        $quotation = Quotation::find($id);

        if ($quotation) {
            $pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/quotation/pdf',
                ['quotation' => $quotation]);

            return $pdf->stream("cotización-$quotation->id.pdf");
        }

        return response('', 404);
    }
}
