<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexValue extends Model
{
    private $previous;

    protected $table = 'index_value';

    protected $fillable = ['type_id','index_id','value'];

    public function type()
    {
        return $this->belongsTo('App\Models\IndexType','type_id','id');
    }

    public function index()
    {
        return $this->belongsTo('App\Models\Index','index_id','id');
    }

    public function previous(IndexValue $previous=null)
    {
        if(!is_null($previous)) {
            $this->previous = $previous;
        } else {
            $previous = $this->index->previous;
            if(is_null($previous)) return null;
            $type = $this->type_id;
            $this->previous = $previous->indexValue->filter(function ($item) use ($type)
            {
                return $item->type_id==$type;
            })->first();
        }
        return $this->previous;
    }

    public function previousValue()
    {
        return is_null($this->previous) ? 0 : $this->previous->value;
    }

    public function change()
    {
        $previous = is_null($this->previous) ? 0 : $this->previous->value;
        return round(((float)$this->value - (float)$previous),2);
    }

    public function changePercent()
    {
        if(is_null($this->previous)) return null;
        if(is_null($this->previous->value) || $this->previous->value == 0) return null;

        return round((((float) $this->value - (float) $this->previous->value)/$this->previous->value)*100,2);
    }
    public function previousDate($date, $format = 'j M')
    {
        return ($date = date_create($date)) ? $date->format($format) : 'NA';
    }
}
