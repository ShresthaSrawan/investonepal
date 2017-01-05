<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class StockBuy extends Model
{
    protected $table = 'am_stocks_buy';
    protected $fillable = ['basket_id','company_id','type_id','shareholder_number',
        'certificate_number','owner_name','buy_date','quantity','buy_rate','commission'];

    public function basket()
    {
        return $this->belongsTo('App\Models\AssetsManagement\Basket','basket_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\AssetsManagement\StockType','type_id','id');
    }

    public function sell()
    {
        return $this->hasMany('App\Models\AssetsManagement\StockSell','buy_id','id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\AssetsManagement\StockDetails','buy_id','id');
    }
}
