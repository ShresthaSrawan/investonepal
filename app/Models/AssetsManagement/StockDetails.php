<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class StockDetails extends Model
{
    protected $table = 'am_stock_details';
    protected $fillable = ['buy_id','fiscal_year_id','stock_dividend','cash_dividend','right_share','remarks'];

    public function buy()
    {
        return $this->belongsTo('App\Models\AssetsManagement\StockBuy','buy_id','id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo('App\Models\FiscalYear','fiscal_year_id','id');
    }
}
