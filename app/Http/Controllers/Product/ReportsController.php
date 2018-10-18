<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportCashDay;
use App\Http\Requests\ReportMerchandiseIncomeDay;
use App\Http\Requests\ReportSalesDay;
use App\Http\Requests\ReportSalesUserDay;
use App\Models\AccountsReceivable;
use App\Models\Category;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Movement;
use App\Models\Product;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DB;
use PDF;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function reportsDiscountDay(Request $request)
    {
        return view('product/report/report-discount-day');
    }

    public function viewReportDiscountDay(ReportCashDay $request)
    {
        $date = $request->get('date');

        return response()->json(['url' => url('product/reports/discount/day/pdf', ['date' => $date])], 200, [],
            JSON_UNESCAPED_UNICODE);
    }

    public function viewReportDiscountDayPDF($date)
    {
        $formatDate = Carbon::createFromFormat('d-m-Y', $date);
        $searchDate = $formatDate->format('Y-m-d');

        $display_date = $formatDate->format('d/m/Y');

        $invoices = Invoice::whereDate('created_at', '=', $searchDate)->where('discount', '>', 0)->get();

        if ( ! $invoices->isEmpty()) {

            $invoiceTotal         = $invoices->sum('total');
            $invoiceDiscountTotal = $invoices->sum('discount');

            $pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/report/pdf-discount-day',
                [
                    'invoices'                => $invoices,
                    'date'                    => $display_date,
                    'invoices_total'          => $invoiceTotal,
                    'invoices_discount_total' => $invoiceDiscountTotal,
                    'total'                   => ($invoiceTotal - $invoiceDiscountTotal)
                ]);

            return $pdf->stream("reporte-descuento-$display_date.pdf");
        }

        return abort(404);
    }

    public function reportsCashDay(Request $request)
    {
        return view('product/report/report-cash-day');
    }

    public function viewReportCashDay(ReportCashDay $request)
    {
        $date = $request->get('date');

        return response()->json(['url' => url('product/reports/cash/day/pdf', ['date' => $date])], 200, [],
            JSON_UNESCAPED_UNICODE);
    }

    public function viewReportCashDayPDF($date)
    {
        $formatDate = Carbon::createFromFormat('d-m-Y', $date);
        $searchDate = $formatDate->format('Y-m-d');

        $display_date = $formatDate->format('d/m/Y');

        $invoices = Invoice::whereDate('created_at', '=', $searchDate)->get();

        if ( ! $invoices->isEmpty()) {
            $accountsReceivablesTotal = $invoices->sum(function ($invoice) use ($searchDate) {
                return $invoice->accountsReceivables()->whereDate('created_at', '=', $searchDate)->sum('total');
            });


            //$total = $accountsReceivablesTotal + $invoiceTotal;

            $creditTotal = $invoices->sum(function ($invoice) {
                return $invoice->paymentMethods->where('description', '=', 'Credito')->sum('amount');
            });

            $cashTotal = $invoices->sum(function ($invoice) {
                return $invoice->paymentMethods->where('description', '=', 'Efectivo')->sum('amount');
            });

            $cardTotal = $invoices->sum(function ($invoice) {
                return $invoice->paymentMethods->where('description', '=', 'Tarjeta')->sum('amount');
            });

            $checkTotal = $invoices->sum(function ($invoice) {
                return $invoice->paymentMethods->where('description', '=', 'Cheque')->sum('amount');
            });

            $depositTotal = $invoices->sum(function ($invoice) {
                return $invoice->paymentMethods->where('description', '=', 'Deposito')->sum('amount');
            });

            $invoiceTotal = ($creditTotal + $cashTotal + $checkTotal + $depositTotal);

            $total = $accountsReceivablesTotal + $invoiceTotal;

            $pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/report/pdf-cash-day',
                [
                    'invoices'                   => $invoices,
                    'date'                       => $display_date,
                    'credit_total'               => $creditTotal,
                    'cash_total'                 => $cashTotal,
                    'card_total'                 => $cardTotal,
                    'check_total'                => $checkTotal,
                    'deposit_total'              => $depositTotal,
                    'invoices_total'             => $invoiceTotal,
                    'accounts_receivables_total' => $accountsReceivablesTotal,
                    'total'                      => $total
                ]);

            return $pdf->stream("reporte-efectivo-$display_date.pdf");
        }

        return abort(404);
    }

    public function reportsSalesDay(Request $request)
    {
        return view('product/report/report-sales-day');
    }

    public function viewReportSalesDay(ReportSalesDay $request)
    {
        $date          = $request->get('date');
        $paymentMethod = $request->get('payment_method');

        return response()->json([
            'url' => url('product/reports/sales/day/pdf', ['date' => $date, 'paymentMethod' => $paymentMethod])
        ], 200, [],
            JSON_UNESCAPED_UNICODE);
    }

    public function viewReportSalesDayPDF($date, $paymentMethod)
    {
        $formatDate = Carbon::createFromFormat('d-m-Y', $date);
        $searchDate = $formatDate->format('Y-m-d');

        $display_date = $formatDate->format('d/m/Y');

        $invoices = Invoice::whereDate('created_at', '=', $searchDate)
                           ->where('void_status', '=', 'N')
                           ->paymentMethod($paymentMethod)
                           ->get();

        if ( ! $invoices->isEmpty()) {

            $total = $invoices->sum('totalWithDiscount');

            return view('product/report/pdf-sales-day',
                [
                    'invoices' => $invoices,
                    'type'     => $paymentMethod,
                    'date'     => $display_date,
                    'total'    => $total
                ]);

            /*$pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/report/pdf-sales-day',
                [
                    'invoices' => $invoices,
                    'type'     => $paymentMethod,
                    'date'     => $display_date,
                    'total'    => $total
                ]);

            return $pdf->stream("reporte-ventas-$display_date.pdf");*/
        }

        return abort(404);
    }

    public function reportsCashMonth(Request $request)
    {
        return view('product/report/report-cash-month');
    }

    public function viewReportCashMonth(ReportCashDay $request)
    {
        $date = $request->get('date');

        return response()->json(['url' => url('product/reports/cash/month/pdf', ['date' => $date])], 200, [],
            JSON_UNESCAPED_UNICODE);
    }

    public function viewReportCashMonthPDF($date)
    {
        $formatDate = Carbon::createFromFormat('d-m-Y', $date);
        $month      = $formatDate->format('m');
        $year       = $formatDate->format('Y');

        $display_date = $formatDate->format('m/Y');

        $invoices = Invoice::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->get();

        if ( ! $invoices->isEmpty()) {
            $accountsReceivablesTotal = $invoices->sum(function ($invoice) use ($month, $year) {
                return $invoice->accountsReceivables()->whereMonth('created_at', '=', $month)->whereYear('created_at',
                    '=', $year)->sum('total');
            });

            $invoiceTotal = $invoices->sum('total');

            $total = $accountsReceivablesTotal + $invoiceTotal;

            $cashTotal = $invoices->sum(function ($invoice) {
                return $invoice->paymentMethods->where('description', '=', 'Efectivo')->sum('amount');
            });

            $cardTotal = $invoices->sum(function ($invoice) {
                return $invoice->paymentMethods->where('description', '=', 'Tarjeta')->sum('amount');
            });

            $checkTotal = $invoices->sum(function ($invoice) {
                return $invoice->paymentMethods->where('description', '=', 'Cheque')->sum('amount');
            });

            $depositTotal = $invoices->sum(function ($invoice) {
                return $invoice->paymentMethods->where('description', '=', 'Deposito')->sum('amount');
            });

            $pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/report/pdf-cash-month',
                [
                    'invoices'                   => $invoices,
                    'date'                       => $display_date,
                    'cash_total'                 => $cashTotal,
                    'card_total'                 => $cardTotal,
                    'check_total'                => $checkTotal,
                    'deposit_total'              => $depositTotal,
                    'invoices_total'             => $invoiceTotal,
                    'accounts_receivables_total' => $accountsReceivablesTotal,
                    'total'                      => $total
                ]);

            return $pdf->stream("reporte-efectivo-$display_date.pdf");
        }

        return abort(404);
    }

    public function reportsSalesUserDay(Request $request)
    {
        $users = User::get()->pluck('name', 'id');
        $users->prepend('', '');

        return view('product/report/report-sales-user-day', ['users' => $users]);
    }

    public function viewReportSalesUserDay(ReportSalesUserDay $request)
    {
        $date    = $request->get('date');
        $user    = $request->get('user');
        $details = $request->get('details');

        $details = $details ? 'y' : 'n';

        return response()->json([
            'url' => url('product/reports/sales/user/day/pdf', ['id' => $user, 'date' => $date, 'details' => $details])
        ],
            200,
            [],
            JSON_UNESCAPED_UNICODE);
    }

    public function viewReportSalesUserDayPDF($id, $date, $details)
    {
        $formatDate = Carbon::createFromFormat('d-m-Y', $date);
        $searchDate = $formatDate->format('Y-m-d');

        $display_date = $formatDate->format('d/m/Y');
        $user         = User::find($id);

        $invoices = Invoice::whereDate('created_at', '=', $searchDate)->where('user_id', '=', $id)->get();

        if ( ! $invoices->isEmpty()) {

            $total    = $invoices->sum('totalWithDiscount');
            $invoices = $details == 'y' ? $invoices : [];

            return view('product/report/pdf-sales-user-day',
                [
                    'invoices' => $invoices,
                    'user'     => $user,
                    'date'     => $display_date,
                    'total'    => $total
                ]);

            /*$pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/report/pdf-sales-user-day',
                [
                    'invoices' => $invoices,
                    'user'     => $user,
                    'date'     => $display_date,
                    'total'    => $total
                ]);

            return $pdf->stream("reporte-ventas-usuario-dia-$display_date.pdf");*/
        }

        return abort(404);
    }

    public function reportsSalesUserMonth(Request $request)
    {
        $users = User::get()->pluck('name', 'id');
        $users->prepend('', '');

        $months = [
            ''   => '',
            '1'  => 'Enero',
            '2'  => 'Febrero',
            '3'  => 'Marzo',
            '4'  => 'Abril',
            '5'  => 'Mayo',
            '6'  => 'Junio',
            '7'  => 'Julio',
            '8'  => 'Agosto',
            '9'  => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];

        return view('product/report/report-sales-user-month', ['users' => $users, 'months' => $months]);
    }

    public function viewReportSalesUserMonth(ReportSalesUserDay $request)
    {
        $date    = $request->get('date');
        $user    = $request->get('user');
        $details = $request->get('details');

        $details = $details ? 'y' : 'n';

        return response()->json([
            'url' => url('product/reports/sales/user/month/pdf',
                ['id' => $user, 'date' => $date, 'details' => $details])
        ], 200,
            [],
            JSON_UNESCAPED_UNICODE);
    }

    public function viewReportSalesUserMonthPDF($id, $date, $details)
    {
        $month = $date;
        $year  = date('Y');

        $display_date = "$month/$year";
        $user         = User::find($id);

        $invoices = Invoice::whereMonth('created_at', '=', $month)
                           ->whereYear('created_at', '=', $year)
                           ->where('user_id', '=', $id)
                           ->orderBy('created_at', 'DESC')
                           ->get();

        if ( ! $invoices->isEmpty()) {

            $total    = $invoices->sum('totalWithDiscount');
            $invoices = $details == 'y' ? $invoices : [];

            return view('product/report/pdf-sales-user-month',
                [
                    'invoices' => $invoices,
                    'user'     => $user,
                    'date'     => $display_date,
                    'total'    => $total
                ]);

            /*$pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/report/pdf-sales-user-month',
                [
                    'invoices' => [],//$invoices->take(20),
                    'user'     => $user,
                    'date'     => $display_date,
                    'total'    => $total
                ]);

            return $pdf->stream("reporte-ventas-usuario-dia-$display_date.pdf");*/
        }

        return abort(404);
    }

    public function reportsAccountsReceivables(Request $request)
    {
        return view('product/report/report-accounts-recievables');
    }

    public function viewReportAccountsReceivables(Request $request)
    {
        return response()->json([
            'url' => url('product/reports/accounts-receivables/pdf')
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function viewReportAccountsReceivablesPDF()
    {
        $accountsReceivables = AccountsReceivable::with('invoice')->where('status', '=', 'N')->get();


        if ( ! $accountsReceivables->isEmpty()) {

            $total = $accountsReceivables->sum('invoice.totalWithDiscount');


            return view('product/report/pdf-accounts-receivables',
                [
                    'accountsReceivables' => $accountsReceivables,
                    'total'               => $total
                ]);

            /*$pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/report/pdf-accounts-receivables',
                [
                    'accountsReceivables' => $accountsReceivables,
                    'total'               => $total
                ]);

            return $pdf->stream("reporte-cuentas-por-cobrar-$date.pdf");*/
        }

        return abort(404);
    }


    public function reportsCategoryProducts(Request $request)
    {
        $categories = Category::get()->pluck('description', 'id');

        return view('product/report/report-category-products', ['categories' => $categories]);
    }

    public function viewReportCategoryProducts(Request $request)
    {
        $category = $request->get('category');

        return response()->json(['url' => url('product/reports/category-products/pdf', ['category' => $category])], 200,
            [],
            JSON_UNESCAPED_UNICODE);
    }

    public function viewReportCategoryProductsPDF($category)
    {

        $products = Product::category($category)->get();
        $category = Category::find($category);

        if ( ! $products->isEmpty()) {

            return view('product/report/pdf-category-products', [
                'products' => $products,
                'category' => $category,
            ]);

            /*$pdf = PDF::setPaper(array(0, 0, 595.28, 841.89))->loadView('product/report/pdf-sales-day',
                [
                    'products' => $products,
                ]);

            return $pdf->stream("reporte-ventas-$display_date.pdf");*/
        }

        return abort(404);
    }

    public function reportsProviderProducts(Request $request)
    {
        $providers = Provider::get()->pluck('name', 'id');

        return view('product/report/report-provider-products', ['providers' => $providers]);
    }

    public function viewReportProviderProducts(Request $request)
    {
        $provider = $request->get('provider');

        return response()->json(['url' => url('product/reports/provider-products/pdf', ['provider' => $provider])], 200,
            [],
            JSON_UNESCAPED_UNICODE);
    }

    public function viewReportProviderProductsPDF($provider)
    {

        $products = Product::provider($provider)->get();
        $provider = Provider::find($provider);

        if ( ! $products->isEmpty()) {

            return view('product/report/pdf-provider-products', [
                'products' => $products,
                'provider' => $provider,
            ]);
        }

        return abort(404);
    }


    public function reportsMerchandiseIncomeDay(Request $request)
    {
        return view('product/report/report-merchandise-income-day');
    }

    public function viewReportMerchandiseIncomeDay(ReportMerchandiseIncomeDay $request)
    {
        $date = $request->get('date');

        return response()->json(['url' => url('product/reports/merchandise-income-day/pdf', ['date' => $date])], 200,
            [],
            JSON_UNESCAPED_UNICODE);
    }

    public function viewReportMerchandiseIncomeDayPDF($date)
    {
        $formatDate   = Carbon::createFromFormat('d-m-Y', $date);
        $searchDate   = $formatDate->format('Y-m-d');
        $display_date = $formatDate->format('d/m/Y');

        $documents = Document::with('movements')
                             ->whereDate('created_at', '=', $searchDate)
                             ->where('output_type', '=', 'E')
                             ->get();

        if ( ! $documents->isEmpty()) {

            $total = $documents->sum(function ($query) {
                return $query->movements()->sum('total');
            });

            return view('product/report/pdf-merchandise-income-day', [
                'documents' => $documents,
                'date'      => $display_date,
                'total'     => $total
            ]);
        }

        return abort(404);
    }
}
