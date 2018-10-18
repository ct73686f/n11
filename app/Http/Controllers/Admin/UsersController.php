<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use App\Http\Requests\EditUser;
use App\Models\User;
use Illuminate\Http\Request;
use Ultraware\Roles\Models\Role;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        $pages = $request->get('pages', 10);
        $users = User::sortable()->paginate($pages);

        return view('admin/user/users', ['users' => $users]);
    }

    public function newUser(Request $request)
    {
        $roles = Role::all();

        return view('admin/user/new', ['roles' => $roles]);
    }

    public function editUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $roles = Role::all();
            $user_roles = $user->roles()->get()->toArray();
            $user_role = array_shift($user_roles);

            return view('admin/user/edit', ['roles' => $roles, 'user' => $user, 'user_role' => $user_role]);
        }

        return response('', 404);
    }

    public function saveEditUser(EditUser $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->name = $request->get('name');
            $user->email = $request->get('email');

            if ($request->has('password')) {
                $user->password = bcrypt($request->get('password'));
            }

            $user->detachAllRoles();
            $user->attachRole($request->get('role'));

            $user->save();

            return redirect('admin/users')->with([
                'status' => 'Usuario actualizado exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function addNewUser(StoreUser $request)
    {
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $user->attachROle($request->get('role'));

        return redirect('admin/users')->with([
            'status' => 'Nuevo usuario agregado exitosamente'
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            return view('admin/user/delete', ['user' => $user]);
        }

        return response('', 404);
    }

    public function proceedDeleteUser($id)
    {
        $user = User::find($id);

        if ($user) {

            if (count($user->invoices) || count($user->movements) || count($user->inventories)) {

                $message = 'Este usuario no puede ser eliminado ya que esta referenciado en ';

                $countMessage = [];

                if (count($user->invoices)) {
                    $invoicesCount = $user->invoices->count();
                    $countMessage[] = "$invoicesCount ventas de mercaderia";
                }

                if (count($user->movements)) {
                    $movementsCount = $user->movements->count();
                    $countMessage[] = "$movementsCount movimientos";
                }

                if (count($user->inventories)) {
                    $inventoriesCount = $user->inventories->count();
                    $countMessage[] = "$inventoriesCount productos";
                }

                $message .= implode(', ', $countMessage) . '.';

                return redirect("admin/users/delete/{$user->id}")->with([
                    'error' => $message
                ]);

            } else {
                $user->delete();

                return redirect('admin/users')->with([
                    'status' => 'Usuario eliminado exitosamente'
                ]);
            }

        }

        return response('', 404);
    }
}
