<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnergyType extends Model
{
    protected $table = 'energy_type';

    protected $fillable = ['id','name','unit'];

    public function energyPrice()
    {
        return $this->hasMany('App\Models\EnergyPrice','id','type_id');
    }
}
