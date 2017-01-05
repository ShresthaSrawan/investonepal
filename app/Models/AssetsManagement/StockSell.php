<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class StockSell extends Model
{
    protected $table = 'am_stocks_sell';
    protected $fillable = ['buy_id','sell_date','quantity','sell_rate','commission','total_tax','note'];

    public function buy()
    {
        return $this->belongsTo('App\Models\AssetsManagement\StockBuy','buy_id','id');
    }
}
