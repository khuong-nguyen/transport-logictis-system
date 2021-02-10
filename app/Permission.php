<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    public static function defaultPermissions()
    {
        return [           
            'role-list',
            'role-create',
            'role-delete',
            'role-delete',
        ];
    }
}
