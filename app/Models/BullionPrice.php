<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BullionPrice extends Model
{
    private $previous;

    protected $table='bullion_price';
    protected $fillable = ['type_id', 'bullion_id', 'price'];

    public function type()
    {
        return $this->belongsTo('App\Models\BullionType','type_id', 'id');
    }

    public function bullion()
    {
        return $this->belongsTo('App\Models\Bullion','bullion_id', 'id');
    }

    public function previous(BullionPrice $previous=null)
    {
        if(!is_null($previous)) {
            $this->previous = $previous;
        } else {
            $previous = $this->bullion->previous;
            if(is_null($previous)) return null;
            $type = $this->type_id;
            $this->previous = $previous->bullionPrice->filter(function ($item) use ($type)
            {
                return $item->type_id==$type;
            })->first();
        }
        return $this->previous;
    }

    public function previousPrice()
    {
        return is_null($this->previous) ? 0 : $this->previous->price;
    }

    public function change()
    {
        $previous = is_null($this->previous) ? 0 : $this->previous->price;
        return round(((float)$this->price - (float)$previous),2);
    }

    public function changePercent()
    {
        if(is_null($this->previous)) return null;
        if(is_null($this->previous->price) || $this->previous->price == 0) return null;

        return round((((float) $this->price - (float) $this->previous->price)/$this->previous->price)*100,2);
    }
}
