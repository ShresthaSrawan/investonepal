<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\Eloquent\Collection;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    protected $filter;
    protected $captionize;
    protected $filterIfHasManyRelationIsEmpty;

    protected function initialize()
    {
        $this->filter = function(Collection $collection, array $layer,$value,$returnCollection = false){
            $category = $collection->filter(function($item) use($layer,$value){
                foreach($layer as $l):
                    $item = $item->$l;
                endforeach;

                return strtolower($item) == strtolower($value);
            });

            return ($returnCollection == false) ? $category->first() : $category;
        };

        $this->captionize = function($string,$start,$width,$append = '...', $stripTags = true){
            if($stripTags === true) $string = strip_tags($string);

            return mb_strimwidth($string,$start,$width,$append);
        };

        $this->filterIfHasManyRelationIsEmpty = function(Collection $collection,$relation,array $param = []){
            return $collection->filter(function($item) use($relation,$param){

                $result = empty($param) ? call_user_func([$item,$relation]) : call_user_func_array([$item,$relation],$param);

                $result = ($result instanceof BelongsToMany || $result instanceof HasMany) ? $result->get() : $result;

                $item->$relation = $result;

                return !$result->isEmpty();
            });
        };
    }
}
