<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    private $previous;

    protected $table = 'currency_rate';

    protected $fillable = ['type_id','currency_id', 'buy', 'sell', 'unit'];

    public function type()
    {
        return $this->belongsTo('App\Models\CurrencyType','type_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency','currency_id', 'id');
    }

    public function previous(CurrencyRate $previous=null)
    {
        if(!is_null($previous)) {
            $this->previous = $previous;
        } else {
            $previous = $this->currency->previous;
            if(is_null($previous)) return null;
            $type = $this->type_id;
            $this->previous = $previous->currencyRate->filter(function ($item) use ($type)
            {
                return $item->type_id==$type;
            })->first();
        }
        return $this->previous;
    }

    public function previousRate($type="buy")
    {
        if(is_null($this->previous)) return null;
        
        return  $this->previous->$type;
    }

    public function change($type="buy")
    {
        if(is_null($this->previous)) return null;
        
        $previous = $this->previous->$type;

        return round(((float)$this->$type - (float)$previous),2);
    }

    public function changePercent($type="buy")
    {
        if(is_null($this->previous)) return null;
        if(is_null($this->previous->$type) || $this->previous->$type == 0) return null;

        return round((((float) $this->$type - (float) $this->previous->$type)/$this->previous->$type)*100,2);
    }
}
