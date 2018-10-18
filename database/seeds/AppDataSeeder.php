<?php

use App\Models\Category;
use App\Models\Client;
use App\Models\Document;
use App\Models\Product;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;

class AppDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(array(
            'name'     => 'Tulio Boch',
            'email'    => 'tulioenriqueboch@gmail.com',
            'password' => bcrypt('123')
        ));

        $adminRole = Role::create([
            'name'        => 'Administrador',
            'slug'        => 'admin',
            'description' => 'Administrador del sistema',
        ]);

        $normalUser = Role::create([
            'name'        => 'Usuario',
            'slug'        => 'user',
            'description' => 'Usuario normal en el sistema',
        ]);

        $user->attachROle($adminRole);

        $nits = [
            '000000000000',
            '111111111111',
            '222222222222',
            '333333333333',
            '444444444444',
            '555555555555',
            '666666666666',
            '777777777777',
            '888888888888',
            '999999999999'
        ];

        for ($i = 1; $i < 11; $i++) {
            Provider::create([
                'name'            => 'Proveedor ' . $i,
                'phone'           => '12345678',
                'address'         => 'Dirección prueba ' . $i,
                'email'           => 'proveedor' . $i . '@mail.com',
                'contact'         => '',
                'website'         => '',
                'additional_info' => ''
            ]);

            Category::create([
                'description' => 'Categoría ' . $i
            ]);

            Client::create([
                'first_name' => 'Cliente',
                'last_name' => $i,
                'address'   => 'Dirección prueba ' . $i,
                'nit'       => $nits[$i - 1],
                'phone'     => '12345678'
            ]);
        }

        Document::create([
            'description' => 'Test documento entrada',
            'output_type' => 'E'
        ]);

        Document::create([
            'description' => 'Test documento salida',
            'output_type' => 'S'
        ]);
    }
}
