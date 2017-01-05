<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class StockType extends Model
{
    protected $table = 'am_stock_types';
    protected $fillable = ['name'];

    public function stock()
    {
        return $this->hasMany('App\Models\AssetManagement\Stock','id','type_id');
    }
}
