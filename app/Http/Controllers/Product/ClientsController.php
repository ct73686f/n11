<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditClient;
use App\Http\Requests\EditCost;
use App\Http\Requests\StoreClient;
use App\Http\Requests\StoreCost;
use App\Models\Client;
use App\Models\Cost;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function clients(Request $request)
    {
        $pages   = $request->get('pages', 10);
        $clients = Client::sortable()->paginate($pages);

        return view('product/client/clients', ['clients' => $clients]);
    }

    public function newClient(Request $request)
    {
        return view('product/client/new');
    }

    public function storeClient(StoreClient $request)
    {
        Client::create([
            'first_name' => $request->get('first_name'),
            'last_name'  => $request->get('last_name'),
            'nit'        => $request->get('nit'),
            'phone'      => $request->get('phone'),
            'address'    => $request->get('address')
        ]);

        return redirect('product/clients')->with([
            'status' => 'Nueva cliente agregado exitosamente'
        ]);
    }

    public function editClient($id)
    {
        $client = Client::find($id);

        if ($client) {
            return view('product/client/edit', ['client' => $client]);
        }

        return response('', 404);
    }

    public function saveEditClient(EditClient $request, $id)
    {
        $client = Client::find($id);

        if ($client) {
            $client->first_name = $request->get('first_name');
            $client->last_name  = $request->get('last_name');
            $client->nit        = $request->get('nit');
            $client->phone      = $request->get('phone');
            $client->address    = $request->get('address');
            $client->save();

            return redirect('product/clients')->with([
                'status' => 'Cliente actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteClient($id)
    {
        $client = Client::find($id);

        if ($client) {
            return view('product/client/delete', ['client' => $client]);
        }

        return response('', 404);
    }

    public function proceedDeleteClient($id)
    {
        $client = Client::find($id);

        if ($client) {

            if (count($client->invoices) || count($client->accountsReceivables)) {

                $message = 'Este cliente no puede ser eliminado ya que esta referenciado en ';

                $countMessage = [];

                if (count($client->invoices)) {
                    $invoicesCount = $client->invoices->count();
                    $countMessage[] = "$invoicesCount ventas de mercaderia";
                }

                if (count($client->accountsReceivables)) {
                    $accountsReceivableCount = $client->accountsReceivables->count();
                    $countMessage[] = "$accountsReceivableCount cuentas por cobrar";
                }

                $message .= implode(', ', $countMessage) . '.';

                return redirect("product/clients/delete/{$client->id}")->with([
                    'error' => $message
                ]);

            } else {
                $client->delete();

                return redirect('product/clients')->with([
                    'status' => 'Cliente eliminado exitosamente'
                ]);
            }

        }

        return response('', 404);
    }
}
