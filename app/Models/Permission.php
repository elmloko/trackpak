<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 *
 * @property $id
 * @property $name
 * @property $guard_name
 * @property $created_at
 * @property $updated_at
 *
 * @property ModelHasPermission $modelHasPermission
 * @property RoleHasPermission $roleHasPermission
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Permission extends Model
{
    
    static $rules = [
		'name' => 'required',
		'guard_name' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','guard_name'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function modelHasPermission()
    {
        return $this->hasOne('App\Models\ModelHasPermission', 'permission_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function roleHasPermission()
    {
        return $this->hasOne('App\Models\RoleHasPermission', 'permission_id', 'id');
    }
    

}
