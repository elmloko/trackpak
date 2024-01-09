<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
    public function modelHasRole()
    {
        return $this->hasOne('App\Models\ModelHasRole', 'role_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleHasPermissions()
    {
        return $this->hasMany('App\Models\RoleHasPermission', 'role_id', 'id');
    }
    

}
