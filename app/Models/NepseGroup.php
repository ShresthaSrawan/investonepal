<?php

namespace App\Models;

use Excel;
use Illuminate\Database\Eloquent\Model;

class NepseGroup extends Model
{
    protected $table = 'nepse_group';

    protected $fillable = ['fiscal_year_id'];

    protected $hidden = ['created_at','updated_at'];

    const FILE_LOCATION = 'assets/nepseGroup/';

    const FILE_NAME = 'nepsegroup';

    public function fiscalYear()
    {
        return $this->belongsTo('App\Models\FiscalYear','fiscal_year_id','id');
    }

    public function nepseGroupGrade()
    {
        return $this->hasMany('App\Models\NepseGroupGrade','nepse_group_id','id');
    }

    public function setGroupFromExcel()
    {
        if(Excel::load('/public/assets/nepseGroup/'.NepseGroup::FILE_NAME.'.xls')):
            $this->nepseGroup = Excel::load('/public/assets/nepseGroup/'.NepseGroup::FILE_NAME.'.xls')->get()->toArray();
        else:
            return false;
        endif;

        NepseGroupDump::truncate();
        foreach($this->nepseGroup as $nepseGroup):
            $ng = new NepseGroupDump;
            $ng->quote = $nepseGroup['quote'];
            $ng->grade = $nepseGroup['grade'];
            $ng->save();
        endforeach;
        
        return true;
    }

    public static function match()
    {
        $dumpCompanys = NepseGroupDump::lists('grade','quote')->toArray();
        $originalCompanys = Company::lists('quote','id')->toArray();

        $unknown = array();
        $matched = [];
        foreach($dumpCompanys as $dump=>$grade)
        {
            $index = array_search($dump, $originalCompanys);
            if($index!==false){
                $matched[$index]=$grade;
            } else {
                array_push($unknown,$dump);
            }
        }
        return ['unknown'=>$unknown,'matched'=>$matched];
    }
}
