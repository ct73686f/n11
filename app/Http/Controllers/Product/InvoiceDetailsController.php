<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditInvoiceDetail;
use App\Http\Requests\StoreInvoiceDetail;
use App\Models\Cost;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function invoiceDetails(Request $request)
    {
        $pages          = $request->get('pages', 10);
        $invoiceDetails = InvoiceDetail::sortable()->paginate($pages);

        return view('product/invoice-detail/invoice-details', ['invoiceDetails' => $invoiceDetails]);
    }

    public function newInvoiceDetail(Request $request)
    {
        $invoices = Invoice::pluck('description', 'id');
        $products = Product::pluck('description', 'id');
        $products->prepend('', '');

        return view('product/invoice-detail/new', ['products' => $products, 'invoices' => $invoices]);
    }

    public function storeInvoiceDetail(StoreInvoiceDetail $request)
    {
        $invoice  = $request->get('invoice');
        $product  = $request->get('product');
        $cost     = $request->get('cost');
        $price    = $request->get('price');
        $quantity = $request->get('quantity');

        $productCost  = Cost::find($cost);
        $productPrice = 0;

        if ($price == 'UP') {
            $productPrice = $productCost->unit_price;
        } elseif ($price == 'WS') {
            $productPrice = $productCost->wholesale_price;
        }

        $total = ($productPrice * $quantity);

        InvoiceDetail::create([
            'invoice_id' => $invoice,
            'product_id' => $product,
            'cost_id'    => $cost,
            'quantity'   => $quantity,
            'unit_price' => $productPrice,
            'unit_cost'  => $productCost->unit_cost,
            'sub_total'  => $total,
        ]);

        $productInventory = Inventory::where('product_id', '=', $product)->first();

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

        // Update invoice total and Client credit amount
        $parentInvoice  = Invoice::find($invoice);
        $invoiceDetails = $parentInvoice->invoiceDetails;

        $invoiceTotal   = 0;

        foreach ($invoiceDetails as $invoiceDetail) {
            $invoiceTotal += $invoiceDetail->sub_total;
        }

        $credit         = $parentInvoice->client->credit;
        $credit->amount = $invoiceTotal;
        $credit->save();

        $parentInvoice->total = $invoiceTotal;
        $parentInvoice->save();

        $request->session()->flash('status', 'Nuevo detalle de factura agregado exitosamente');

        return response()->json([], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function editInvoiceDetail($id)
    {
        $cost = InvoiceDetail::find($id);

        if ($cost) {
            $products = Product::pluck('description', 'id');

            return view('product/invoice-detail/edit', ['cost' => $cost, 'products' => $products]);
        }

        return response('', 404);
    }

    public function saveEditInvoiceDetail(EditInvoiceDetail $request, $id)
    {
        $cost = InvoiceDetail::find($id);

        if ($cost) {
            $cost->product_id      = $request->get('product');
            $cost->unit_price      = $request->get('unit_price');
            $cost->unit_cost       = $request->get('unit_cost');
            $cost->wholesale_price = $request->get('wholesale_price');
            $cost->save();

            return redirect('product/invoiceDetails')->with([
                'status' => 'InvoiceDetailo actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteInvoiceDetail($id)
    {
        $cost = InvoiceDetail::find($id);

        if ($cost) {
            return view('product/invoice-detail/delete', ['cost' => $cost]);
        }

        return response('', 404);
    }

    public function proceedDeleteInvoiceDetail($id)
    {
        $cost = InvoiceDetail::find($id);

        if ($cost) {
            $cost->delete();

            return redirect('product/invoiceDetails')->with([
                'status' => 'InvoiceDetailo eliminado exitosamente'
            ]);
        }

        return response('', 404);
    }
}
