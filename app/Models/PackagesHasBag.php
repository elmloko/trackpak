<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PackagesHasBag
 *
 * @property $id
 * @property $bags_id
 * @property $packages_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Bag $bag
 * @property Package $package
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PackagesHasBag extends Model
{
    
    static $rules = [
		'bags_id' => 'required',
		'packages_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['bags_id','packages_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bag()
    {
        return $this->hasOne('App\Models\Bag', 'id', 'bags_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function package()
    {
        return $this->hasOne('App\Models\Package', 'id', 'packages_id');
    }
    

}
