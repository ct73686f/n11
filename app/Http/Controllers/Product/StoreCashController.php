<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditDocument;
use App\Http\Requests\EditProduct;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\StoreProduct;
use App\Models\Document;
use App\Models\Product;
use App\Models\Provider;
use App\Models\StoreCash;
use Illuminate\Http\Request;
use PDF;

class StoreCashController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function storeCash(Request $request)
    {
        $pages     = $request->get('pages', 10);
        $storeCash = StoreCash::sortable()->paginate($pages);

        return view('product/store-cash/store-cash', ['storeCash' => $storeCash]);
    }
}
