<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table='sector';
    protected $fillable = ['id','label'];

    public function countCompany()
    {
        return Company::where('sector_id',$this->id)->count();
    }
}
