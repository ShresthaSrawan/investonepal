<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPOResult extends Model
{
    const FILE_LOCATION = 'assets/ipo_result/';
    const FILE_NAME = 'ipo_result';
    
    protected $table = 'ipo_result';

    protected $fillable = ['id', 'excel','company_id', 'code', 'application_no', 'first_name', 'last_name', 'applied_kitta', 'alloted_kitta', 'date'];
    
    
    public function company(){
		return $this->belongsTo('App\Models\Company','company_id', 'id');
	}
    
}
