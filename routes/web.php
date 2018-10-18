<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index');


    Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function () {
        Route::get('users', 'Admin\UsersController@users');
        Route::get('users/new', 'Admin\UsersController@newUser');
        Route::post('users/new', 'Admin\UsersController@addNewUser');
        Route::get('users/edit/{id}', 'Admin\UsersController@editUser');
        Route::post('users/edit/{id}', 'Admin\UsersController@saveEditUser');
        Route::get('users/delete/{id}', 'Admin\UsersController@deleteUser');
        Route::post('users/delete/{id}', 'Admin\UsersController@proceedDeleteUser');
    });

    Route::group(['prefix' => 'product', 'middleware' => 'role:admin'], function () {


        // Categories
        Route::get('categories', 'Product\CategoriesController@categories');
        Route::get('categories/new', 'Product\CategoriesController@newCategory');
        Route::post('categories/new', 'Product\CategoriesController@storeCategory');
        Route::get('categories/edit/{id}', 'Product\CategoriesController@editCategory');
        Route::post('categories/edit/{id}', 'Product\CategoriesController@saveEditCategory');
        Route::get('categories/delete/{id}', 'Product\CategoriesController@deleteCategory');
        Route::post('categories/delete/{id}', 'Product\CategoriesController@proceedDeleteCategory');

        // Providers
        Route::get('providers', 'Product\ProvidersController@providers');
        Route::get('providers/new', 'Product\ProvidersController@newProvider');
        Route::post('providers/new', 'Product\ProvidersController@storeProvider');
        Route::get('providers/edit/{id}', 'Product\ProvidersController@editProvider');
        Route::post('providers/edit/{id}', 'Product\ProvidersController@saveEditProvider');
        Route::get('providers/delete/{id}', 'Product\ProvidersController@deleteProvider');
        Route::post('providers/delete/{id}', 'Product\ProvidersController@proceedDeleteProvider');

        // Products
        Route::get('products', 'Product\ProductsController@products');
        Route::get('products/new', 'Product\ProductsController@newProduct');
        Route::post('products/new', 'Product\ProductsController@storeProduct');
        Route::get('products/edit/{id}', 'Product\ProductsController@editProduct');
        Route::post('products/edit/{id}', 'Product\ProductsController@saveEditProduct');
        Route::get('products/delete/{id}', 'Product\ProductsController@deleteProduct');
        Route::post('products/delete/{id}', 'Product\ProductsController@proceedDeleteProduct');

        // Costs
        Route::get('costs', 'Product\CostsController@costs');
        Route::get('costs/new', 'Product\CostsController@newCost');
        Route::post('costs/new', 'Product\CostsController@storeCost');
        Route::get('costs/edit/{id}', 'Product\CostsController@editCost');
        Route::post('costs/edit/{id}', 'Product\CostsController@saveEditCost');
        Route::get('costs/delete/{id}', 'Product\CostsController@deleteCost');
        Route::post('costs/delete/{id}', 'Product\CostsController@proceedDeleteCost');

        // Clients
        Route::get('clients', 'Product\ClientsController@clients');
        Route::get('clients/new', 'Product\ClientsController@newClient');
        Route::post('clients/new', 'Product\ClientsController@storeClient');
        Route::get('clients/edit/{id}', 'Product\ClientsController@editClient');
        Route::post('clients/edit/{id}', 'Product\ClientsController@saveEditClient');
        Route::get('clients/delete/{id}', 'Product\ClientsController@deleteClient');
        Route::post('clients/delete/{id}', 'Product\ClientsController@proceedDeleteClient');

        // Accounts Receivables
        Route::get('accounts-receivables', 'Product\AccountsReceivablesController@accountsReceivables');
        Route::get('accounts-receivables/new', 'Product\AccountsReceivablesController@newAccountsReceivable');
        Route::post('accounts-receivables/new', 'Product\AccountsReceivablesController@storeAccountsReceivable');
        Route::get('accounts-receivables/edit/{id}', 'Product\AccountsReceivablesController@editAccountsReceivable');
        Route::post('accounts-receivables/edit/{id}',
            'Product\AccountsReceivablesController@saveEditAccountsReceivable');
        Route::get('accounts-receivables/delete/{id}',
            'Product\AccountsReceivablesController@deleteAccountsReceivable');
        Route::post('accounts-receivables/delete/{id}',
            'Product\AccountsReceivablesController@proceedDeleteAccountsReceivable');

        // Debts
        Route::get('debts', 'Product\DebtsController@debts');
        Route::get('debts/new', 'Product\DebtsController@newDebt');
        Route::post('debts/new', 'Product\DebtsController@storeDebt');
        Route::get('debts/edit/{id}', 'Product\DebtsController@editDebt');
        Route::post('debts/edit/{id}',
            'Product\DebtsController@saveEditDebt');
        Route::get('debts/delete/{id}',
            'Product\DebtsController@deleteDebt');
        Route::post('debts/delete/{id}',
            'Product\DebtsController@proceedDeleteDebt');

        // Invoice Details
        Route::get('invoice-details', 'Product\InvoiceDetailsController@invoiceDetails');
        Route::get('invoice-details/new', 'Product\InvoiceDetailsController@newInvoiceDetail');
        Route::post('invoice-details/new', 'Product\InvoiceDetailsController@storeInvoiceDetail');
        Route::get('invoice-details/edit/{id}', 'Product\InvoiceDetailsController@editInvoiceDetail');
        Route::post('invoice-details/edit/{id}', 'Product\InvoiceDetailsController@saveEditInvoiceDetail');
        Route::get('invoice-details/delete/{id}', 'Product\InvoiceDetailsController@deleteInvoiceDetail');
        Route::post('invoice-details/delete/{id}', 'Product\InvoiceDetailsController@proceedDeleteInvoiceDetail');

        // CreditTypes
        Route::get('credit-types', 'Product\CreditTypesController@creditTypes');
        Route::get('credit-types/new', 'Product\CreditTypesController@newCreditType');
        Route::post('credit-types/new', 'Product\CreditTypesController@storeCreditType');
        Route::get('credit-types/edit/{id}', 'Product\CreditTypesController@editCreditType');
        Route::post('credit-types/edit/{id}', 'Product\CreditTypesController@saveEditCreditType');
        Route::get('credit-types/delete/{id}', 'Product\CreditTypesController@deleteCreditType');
        Route::post('credit-types/delete/{id}', 'Product\CreditTypesController@proceedDeleteCreditType');

        // PaymentMethods
        Route::get('payment-methods', 'Product\PaymentMethodsController@paymentMethods');
        Route::get('payment-methods/new', 'Product\PaymentMethodsController@newPaymentMethod');
        Route::post('payment-methods/new', 'Product\PaymentMethodsController@storePaymentMethod');
        Route::get('payment-methods/edit/{id}', 'Product\PaymentMethodsController@editPaymentMethod');
        Route::post('payment-methods/edit/{id}', 'Product\PaymentMethodsController@saveEditPaymentMethod');
        Route::get('payment-methods/delete/{id}', 'Product\PaymentMethodsController@deletePaymentMethod');
        Route::post('payment-methods/delete/{id}', 'Product\PaymentMethodsController@proceedDeletePaymentMethod');

        // Inventories
        Route::get('inventories', 'Product\InventoriesController@inventories');
        Route::get('inventories/new', 'Product\InventoriesController@newInventory');
        Route::post('inventories/new', 'Product\InventoriesController@storeInventory');
        Route::get('inventories/edit/{id}', 'Product\InventoriesController@editInventory');
        Route::post('inventories/edit/{id}', 'Product\InventoriesController@saveEditInventory');
        Route::get('inventories/delete/{id}', 'Product\InventoriesController@deleteInventory');
        Route::post('inventories/delete/{id}', 'Product\InventoriesController@proceedDeleteInventory');

        // Reports
        Route::get('reports/cash/day', 'Product\ReportsController@reportsCashDay');
        Route::post('reports/cash/day', 'Product\ReportsController@viewReportCashDay');
        Route::get('reports/cash/day/pdf/{date}', 'Product\ReportsController@viewReportCashDayPDF');
        Route::get('reports/discount/day', 'Product\ReportsController@reportsDiscountDay');
        Route::post('reports/discount/day', 'Product\ReportsController@viewReportDiscountDay');
        Route::get('reports/discount/day/pdf/{date}', 'Product\ReportsController@viewReportDiscountDayPDF');
        Route::get('reports/cash/month', 'Product\ReportsController@reportsCashMonth');
        Route::post('reports/cash/month', 'Product\ReportsController@viewReportCashMonth');
        Route::get('reports/cash/month/pdf/{date}', 'Product\ReportsController@viewReportCashMonthPDF');
        Route::get('reports/sales/user/day', 'Product\ReportsController@reportsSalesUserDay');
        Route::post('reports/sales/user/day', 'Product\ReportsController@viewReportSalesUserDay');
        Route::get('reports/sales/user/day/pdf/{id}/{date}/{details}', 'Product\ReportsController@viewReportSalesUserDayPDF');
        Route::get('reports/sales/user/month', 'Product\ReportsController@reportsSalesUserMonth');
        Route::post('reports/sales/user/month', 'Product\ReportsController@viewReportSalesUserMonth');
        Route::get('reports/sales/user/month/pdf/{id}/{date}/{details}', 'Product\ReportsController@viewReportSalesUserMonthPDF');
        Route::get('reports/accounts-receivables', 'Product\ReportsController@reportsAccountsReceivables');
        Route::post('reports/accounts-receivables', 'Product\ReportsController@viewReportAccountsReceivables');
        Route::get('reports/accounts-receivables/pdf', 'Product\ReportsController@viewReportAccountsReceivablesPDF');

        Route::get('reports/provider-products', 'Product\ReportsController@reportsProviderProducts');
        Route::post('reports/provider-products', 'Product\ReportsController@viewReportProviderProducts');
        Route::get('reports/provider-products/pdf/{provider}', 'Product\ReportsController@viewReportProviderProductsPDF');

        Route::get('reports/category-products', 'Product\ReportsController@reportsCategoryProducts');
        Route::post('reports/category-products', 'Product\ReportsController@viewReportCategoryProducts');
        Route::get('reports/category-products/pdf/{category}', 'Product\ReportsController@viewReportCategoryProductsPDF');

        Route::get('reports/merchandise-income-day', 'Product\ReportsController@reportsMerchandiseIncomeDay');
        Route::post('reports/merchandise-income-day', 'Product\ReportsController@viewReportMerchandiseIncomeDay');
        Route::get('reports/merchandise-income-day/pdf/{date}', 'Product\ReportsController@viewReportMerchandiseIncomeDayPDF');

        // Documents
        Route::get('documents', 'Product\DocumentsController@documents');
        Route::get('documents/new', 'Product\DocumentsController@newDocument');
        Route::post('documents/new', 'Product\DocumentsController@storeDocument');
        Route::get('documents/edit/{id}', 'Product\DocumentsController@editDocument');
        Route::get('documents/pdf/{id}', 'Product\DocumentsController@viewDocumentPDF');
        Route::post('documents/edit/{id}', 'Product\DocumentsController@saveEditDocument');
        Route::get('documents/delete/{id}', 'Product\DocumentsController@deleteDocument');
        Route::post('documents/delete/{id}', 'Product\DocumentsController@proceedDeleteDocument');

        // Store Cash
        Route::get('store-cash', 'Product\StoreCashController@storeCash');

        // Documents Cash
        Route::get('documents-cash', 'Product\DocumentsCashController@documents');
        Route::get('documents-cash/new', 'Product\DocumentsCashController@newDocument');
        Route::post('documents-cash/new', 'Product\DocumentsCashController@storeDocument');
        Route::get('documents-cash/edit/{id}', 'Product\DocumentsCashController@editDocument');
        Route::get('documents-cash/pdf/{id}', 'Product\DocumentsCashController@viewDocumentPDF');
        Route::post('documents-cash/edit/{id}', 'Product\DocumentsCashController@saveEditDocument');
        Route::get('documents-cash/delete/{id}', 'Product\DocumentsCashController@deleteDocument');
        Route::post('documents-cash/delete/{id}', 'Product\DocumentsCashController@proceedDeleteDocument');

        // Movements Cash
        Route::get('movements-cash', 'Product\MovementsCashController@movements');
        Route::get('movements-cash/new', 'Product\MovementsCashController@newMovement');
        Route::post('movements-cash/product', 'Product\MovementsCashController@getMovementProduct');
        Route::post('movements-cash/new', 'Product\MovementsCashController@storeMovement');
        Route::get('movements-cash/edit/{id}', 'Product\MovementsCashController@editMovement');
        Route::post('movements-cash/edit/{id}', 'Product\MovementsCashController@saveEditMovement');
        Route::get('movements-cash/view/{id}', 'Product\MovementsCashController@viewMovement');
        Route::get('movements-cash/pdf/{id}', 'Product\MovementsCashController@viewMovementPDF');
        Route::get('movements-cash/delete/{id}', 'Product\MovementsCashController@deleteMovement');
        Route::post('movements-cash/delete/{id}', 'Product\MovementsCashController@proceedDeleteMovement');
    });

    Route::group(['prefix' => 'product', 'middleware' => 'role:admin|user'], function () {

        Route::get('reports/sales/day', 'Product\ReportsController@reportsSalesDay');
        Route::post('reports/sales/day', 'Product\ReportsController@viewReportSalesDay');
        Route::get('reports/sales/day/pdf/{date}/{paymentMethod}', 'Product\ReportsController@viewReportSalesDayPDF');

        Route::group(['prefix' => 'api'], function () {
            // api getters
            Route::get('get-output-type', function () {
                $id       = Request::get('id');
                $document = App\Models\Document::find($id);
                return ['output_type' => $document->raw_output_type];
            });

            Route::get('search-client', function () {
                $query       = Request::get('query');
                $client     = App\Models\Client::where('phone', '=', $query)->orWhere('nit', '=', $query)->first();

                if ($client) {
                    return ['client' => $client->full_name];
                }

                return ['client' => false];
            });

            Route::get('provider-products', function () {
                $id = Request::get('id');
                return App\Models\Provider::find($id)->products()->get()->prepend('');
            });

            Route::get('product-barcode', function () {
                $code    = Request::get('code');
                $barcode = App\Models\Barcode::where('code', '=', $code)->first();

                if ($barcode) {
                    $product = $barcode->product()->get()->first();

                    return ['id' => $product->id];
                }

                return response()->json(['error' => 'Debe registar este producto antes de agregarlo a un movimiento'],
                    422, [], JSON_UNESCAPED_UNICODE);
            });

            Route::get('product-costs', function () {
                $id = Request::get('id');
                return App\Models\Cost::where('product_id', $id)->get()->prepend('');
            });

            Route::get('invoice-client', function () {
                $id      = Request::get('id');
                $invoice = App\Models\Invoice::find($id);
                $total   = number_format($invoice->total - $invoice->discount, 2);
                return ['client_name' => $invoice->client->full_name, 'total' => $total];
            });
        });


        // Invoices
        Route::get('invoices', 'Product\InvoicesController@invoices');
        Route::get('invoices/new', 'Product\InvoicesController@newInvoice');
        Route::post('invoices/new', 'Product\InvoicesController@storeInvoice');
        Route::get('invoices/product-total', 'Product\InvoicesController@getInvoiceProductTotal');
        Route::post('invoices/product', 'Product\InvoicesController@getInvoiceProduct');
        Route::get('invoices/view/{id}', 'Product\InvoicesController@viewInvoice');
        Route::get('invoices/edit/{id}', 'Product\InvoicesController@editInvoice');
        Route::post('invoices/edit/{id}', 'Product\InvoicesController@saveEditInvoice');
        Route::get('invoices/delete/{id}', 'Product\InvoicesController@deleteInvoice');
        Route::post('invoices/delete/{id}', 'Product\InvoicesController@proceedDeleteInvoice');
        Route::get('invoices/pdf/{id}', 'Product\InvoicesController@viewInvoicePDF');

        // Invoices
        Route::get('quotations', 'Product\QuotationsController@quotations');
        Route::get('quotations/new', 'Product\QuotationsController@newQuotation');
        Route::post('quotations/new', 'Product\QuotationsController@storeQuotation');
        Route::get('quotations/product-total', 'Product\QuotationsController@getQuotationProductTotal');
        Route::post('quotations/product', 'Product\QuotationsController@getQuotationProduct');
        Route::get('quotations/view/{id}', 'Product\QuotationsController@viewQuotation');
        Route::get('quotations/edit/{id}', 'Product\QuotationsController@editQuotation');
        Route::post('quotations/edit/{id}', 'Product\QuotationsController@saveEditQuotation');
        Route::get('quotations/delete/{id}', 'Product\QuotationsController@deleteQuotation');
        Route::post('quotations/delete/{id}', 'Product\QuotationsController@proceedDeleteQuotation');
        Route::get('quotations/pdf/{id}', 'Product\QuotationsController@viewQuotationPDF');

        // Movements
        Route::get('movements', 'Product\MovementsController@movements');
        Route::get('movements/new', 'Product\MovementsController@newMovement');
        Route::post('movements/product', 'Product\MovementsController@getMovementProduct');
        Route::post('movements/new', 'Product\MovementsController@storeMovement');
        Route::get('movements/edit/{id}', 'Product\MovementsController@editMovement');
        Route::post('movements/edit/{id}', 'Product\MovementsController@saveEditMovement');
        Route::get('movements/view/{id}', 'Product\MovementsController@viewMovement');
        Route::get('movements/pdf/{id}', 'Product\MovementsController@viewMovementPDF');
        Route::get('movements/delete/{id}', 'Product\MovementsController@deleteMovement');
        Route::post('movements/delete/{id}', 'Product\MovementsController@proceedDeleteMovement');
    });


});

Auth::routes();


