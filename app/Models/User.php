<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ultraware\Roles\Traits\HasRoleAndPermission;
use Ultraware\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable implements HasRoleAndPermissionContract
{
    use Notifiable, HasRoleAndPermission, Sortable;

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];


    public $sortable = [
        'id',
        'name',
        'email',
        'created_at'
    ];

    public function movements()
    {
        return $this->hasMany('App\Models\Movement', 'user_id', 'id');
    }

    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory', 'user_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice', 'user_id', 'id');
    }
}
