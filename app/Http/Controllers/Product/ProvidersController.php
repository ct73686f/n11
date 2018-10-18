<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProvider;
use App\Http\Requests\StoreProvider;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function providers(Request $request)
    {
        $pages = $request->get('pages', 10);

        if ($request->has('search')) {
            $search    = $request->get('search');
            $providers = Provider::like('name', $search)->sortable()->paginate($pages);
        } else {
            $providers = Provider::sortable()->paginate($pages);
        }

        return view('product/provider/providers', ['providers' => $providers]);
    }

    public function newProvider(Request $request)
    {
        return view('product/provider/new');
    }

    public function storeProvider(StoreProvider $request)
    {
        Provider::create([
            'name'            => $request->get('name'),
            'phone'           => $request->get('phone'),
            'address'         => $request->get('address'),
            'email'           => $request->get('email'),
            'contact'         => $request->get('contact'),
            'website'         => $request->get('website'),
            'additional_info' => $request->get('additional_info')
        ]);

        return redirect('product/providers')->with([
            'status' => 'Nuevo proveedor agregado exitosamente'
        ]);
    }

    public function editProvider($id)
    {
        $provider = Provider::find($id);

        if ($provider) {
            return view('product/provider/edit', ['provider' => $provider]);
        }

        return response('', 404);
    }

    public function saveEditProvider(EditProvider $request, $id)
    {
        $provider = Provider::find($id);

        if ($provider) {
            $provider->name            = $request->get('name');
            $provider->phone           = $request->get('phone');
            $provider->address         = $request->get('address');
            $provider->email           = $request->get('email');
            $provider->contact         = $request->get('contact');
            $provider->website         = $request->get('website');
            $provider->additional_info = $request->get('additional_info');
            $provider->save();

            return redirect('product/providers')->with([
                'status' => 'Proveedor actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteProvider($id)
    {
        $provider = Provider::find($id);

        if ($provider) {
            return view('product/provider/delete', ['provider' => $provider]);
        }

        return response('', 404);
    }

    public function proceedDeleteProvider($id)
    {
        $provider = Provider::find($id);

        if ($provider) {

            if (count($provider->products) || count($provider->debts)) {
                $message = 'Este proveedor no puede ser eliminado ya que esta referenciado en ';

                $countMessage = [];

                if (count($provider->products)) {
                    $productCount   = $provider->products->count();
                    $countMessage[] = "$productCount productos";
                }

                if (count($provider->debts)) {
                    $debtsCount     = $provider->debts->count();
                    $countMessage[] = "$debtsCount cuentas por pagar";
                }

                $message .= implode(', ', $countMessage) . '.';

                return redirect("product/providers/delete/{$provider->id}")->with([
                    'error' => $message
                ]);
            } else {
                $provider->delete();

                return redirect('product/providers')->with([
                    'status' => 'Proveedor eliminado exitosamente'
                ]);
            }
        }

        return response('', 404);
    }
}
