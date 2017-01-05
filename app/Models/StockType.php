<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AssetsManagement\StockBuy;

class StockType extends Model
{
    protected $table = 'am_stock_types';
    protected $fillable = ['name'];

    public function stockBuy()
    {
        return $this->hasMany(StockBuy::class,'type_id','id');
    }
}
