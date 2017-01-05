<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnergyPrice extends Model
{
    private $previous;
    
    protected $table='energy_price';
    protected $fillable = ['type_id', 'energy_id', 'price'];

    public function type()
    {
        return $this->belongsTo('App\Models\EnergyType','type_id','id');
    }

    public function energy()
    {
        return $this->belongsTo('App\Models\Energy','energy_id','id');
    }

    public function previous(EnergyPrice $previous=null)
    {
        if(!is_null($previous)) {
            $this->previous = $previous;
        } else {
            $previous = $this->energy->previous;
            if(is_null($previous)) return null;
            $type = $this->type_id;
            $this->previous = $previous->energyPrice->filter(function ($item) use ($type)
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
