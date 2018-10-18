<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditInvoice;
use App\Http\Requests\GetInvoiceProduct;
use App\Http\Requests\StoreInvoice;
use App\Models\Client;
use App\Models\ClientCredit;
use App\Models\Cost;
use App\Models\CreditType;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\StoreCash;
use Illuminate\Http\Request;
use Auth;
use mPDF;
use Carbon\Carbon;
use PDF;

class InvoicesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function invoices(Request $request)
    {
        $pages    = $request->get('pages', 10);
        $invoices = Invoice::sortable()->orderBy('id', 'DESC')->paginate($pages);

        return view('product/invoice/invoices', ['invoices' => $invoices]);
    }

    public function newInvoice(Request $request)
    {
        $clients = Client::get()->pluck('full_name', 'id');
        $clients->prepend('', '');
        $products = Product::all();

        return view('product/invoice/new', ['clients' => $clients, 'products' => $products]);
    }

    public function getInvoiceProduct(GetInvoiceProduct $request)
    {
        $product   = Product::find($request->get('product'));
        $quantity  = $request->get('quantity');
        $wholesale = $request->get('wholesale');

        //if ($quantity >= $product->wholesale_amount) {
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

    public function getInvoiceProductTotal(Request $request)
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

    public function viewInvoice($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            return view('product/invoice/view', ['invoice' => $invoice]);
        }

        return response('', 404);
    }

    public function storeInvoice(StoreInvoice $request)
    {
        /*$paymentMethod = PaymentMethod::create([
            'description' => $request->get('payment_method')
        ]);

        $creditType = CreditType::create([
            'description' => $request->get('credit_type'),
            'term'        => $request->get('term'),
            'amount'      => $request->get('amount')
        ]);

        ClientCredit::create([
            'credit_type_id' => $creditType['id'],
            'client_id'      => $request->get('client'),
            'amount'         => $request->get('total'),
            'start_date'     => $request->get('start_date'),
            'end_date'       => $request->get('end_date'),
        ]);*/


        $userId            = Auth::id();
        $products          = $request->get('product');
        $quantities        = $request->get('quantity');
        $nit               = $request->get('nit');
        $clientName        = $request->get('client');
        $client            = 0;
        $clientInvoice     = Client::where('nit', '=', $nit)->orWhere('phone', '=', $nit)->first();
        $wholesale_applies = $request->get('wholesale_apply');
        $today             = date('Y-m-d');
        $storeCash         = StoreCash::whereDate('created_at', '=', $today)->first();

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

        $invoice = Invoice::create([
            'user_id'     => $userId,
            'client_id'   => $client,
            //'payment_method_id' => 0,
            //'credit_type_id'    => 0,
            'void_details' => '',
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
            PaymentMethod::create([
                'invoice_id'  => $invoice['id'],
                'description' => 'Credito',
                'amount'      => $credit
            ]);
        }

        if ($cash) {
            PaymentMethod::create([
                'invoice_id'  => $invoice['id'],
                'description' => 'Efectivo',
                'amount'      => $cash
            ]);

            if ($storeCash) {
                $currentCash       = $storeCash->amount;
                $storeCash->amount = ($currentCash + $cash);
                $storeCash->save();
            } else {
                StoreCash::create([
                    'amount' => $cash
                ]);
            }
        }

        if ($card) {
            PaymentMethod::create([
                'invoice_id'  => $invoice['id'],
                'description' => 'Tarjeta',
                'amount'      => $card
            ]);
        }

        if ($check) {
            PaymentMethod::create([
                'invoice_id'  => $invoice['id'],
                'description' => 'Cheque',
                'amount'      => $check
            ]);
        }

        if ($deposit) {
            PaymentMethod::create([
                'invoice_id'  => $invoice['id'],
                'description' => 'Deposito',
                'amount'      => $deposit
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

            InvoiceDetail::create([
                'invoice_id' => $invoice['id'],
                'product_id' => $productId,
                'cost_id'    => $product->cost->id,
                'quantity'   => $quantity,
                'unit_price' => $price,
                'unit_cost'  => $cost,
                'sub_total'  => $total,
            ]);

            $productInventory = Inventory::where('product_id', '=', $productId)->first();

            $initialTotal   = $productInventory->initial;
            $entryTotal     = $productInventory->entry;
            $additionTotal  = $entryTotal;
            $outputTotal    = $productInventory->output;
            $substractTotal = ($outputTotal + $quantity);
            $currentTotal   = (($initialTotal + $additionTotal) - ($substractTotal));

            $productInventory->entry   = $additionTotal;
            $productInventory->output  = $substractTotal;
            $productInventory->current = $currentTotal;
            $productInventory->save();
        }


        // Update invoice total and Client credit amount
        $invoice->surcharge = $surcharge;
        $invoice->total     = $totalInvoice;
        $invoice->save();


        //$request->session()->flash('status', 'Nueva factura agregada exitosamente');

        return response()->json(['url' => url('product/invoices/pdf', ['id' => $invoice['id']])], 200, [],
            JSON_UNESCAPED_UNICODE);
    }

    public function editInvoice($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            $clients = Client::get()->pluck('full_name', 'id');

            return view('product/invoice/edit', ['invoice' => $invoice, 'clients' => $clients]);
        }

        return response('', 404);
    }

    public function saveEditInvoice(EditInvoice $request, $id)
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

    public function deleteInvoice($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            return view('product/invoice/delete', ['invoice' => $invoice]);
        }

        return response('', 404);
    }

    public function proceedDeleteInvoice($id)
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

    public function viewInvoicePDF($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice) {

            //$baseSize     = 320;
            //$pdf          = PDF::loadView('product/invoice/pdf', ['invoice' => $invoice]);
            /*$payemtnsSize = $invoice->paymentMethods->count();
            $detailsSize  = $invoice->invoiceDetails->count();

            $payment = $payemtnsSize * 8;
            $detail = $detailsSize * 8;

            $offset = ($payemtnsSize + $detailsSize) / 2;

            $baseSize = (($baseSize + $payment + $detail) - $offset);*/

            //return $pdf->setPaper(array(0, 0, 226.77, $baseSize))->stream();
            //return $pdf->setPaper(array(0, 0, 226.77, 841.89))->stream();

            //226.771653543
            //841.88976378

            /*$pdf = PDF::setPaper(array(0, 0, 226.77, 226.77))->loadView('product/invoice/pdf', ['invoice' => $invoice]);
            $pdf->output();

            $page_count = $pdf->getDomPDF()->get_canvas()->get_page_number();
            unset( $pdf );*/

            //$pdf = PDF::setPaper(array(0, 0, 226.77, 226.77 * $page_count + 20))->loadView('product/invoice/pdf', ['invoice' => $invoice]);
            $pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/invoice/pdf', ['invoice' => $invoice]);


            //echo $page_count;

            return $pdf->stream("venta-mercaderia-$invoice->id.pdf");
        }

        return response('', 404);
    }
}
