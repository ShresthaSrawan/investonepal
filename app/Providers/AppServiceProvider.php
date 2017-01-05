<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('excel', function($attribute, UploadedFile $file, $params) {
            $mimes = ['application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

            return in_array($file->getClientMimeType(),$mimes);
        });
        
        Validator::extend('alpha_spaces', function($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });

        Validator::extend('alpha_num_spaces', function($attribute, $value) {
            return preg_match('/(^[A-Za-z0-9 ]+$)+/', $value);
        });

        Validator::extend('address', function($attribute, $value){
            return preg_match('/^[a-z\d\-,.\s]+$/i', $value);
        });

        Validator::extend('alpha_num_spaces_braces_dash', function($attribute, $value){
            $allowed = ['{','}',',','_','(',')',':','.'];
            $val = $value;
            foreach($allowed as $char):
                $val = str_replace($char,'',$val);
            endforeach;

            return preg_match('/(^[A-Za-z0-9 ]+$)+/', $val);
        });

	Validator::extend('alpha_num_spaces_percent', function($attribute, $value){
            $val = str_replace('%','',$value);
            return preg_match('/(^[A-Za-z0-9 ]+$)+/', $val);
        });

        Validator::extend('max_file_size', function($attribute, $value, $params){
            if(is_array($value)):
                $checked = []; 
                foreach ($value as $file):
                    if(is_null($file)):
                        $checked[] = true;
                    else:
                        if($file->getError() > 0):
                            $checked[] = false;
                        else:
                            $fileSize = $file->getSize() / 1000;

                            $allowedFileSize = (int) $params[0];            

                            $checked[] = $fileSize < $allowedFileSize;
                        endif;
                    endif; 
                endforeach;

                if(in_array(false, $checked, true)) return false;

                return true;
            else:
                if(is_null($value) || $value->getError() > 0) return false;
            
                $fileSize = $value->getSize() / 1000;

                $allowedFileSize = (int) $params[0];            

                return $fileSize < $allowedFileSize;
            endif;
        });

        Validator::extend('required_multiple', function($attribute, $value, $params){
            $checked = []; 
            foreach ($value as $file):
                if(is_null($file)):
                    $checked[] = false;
                else:
                    $checked[] = true;
                endif; 
            endforeach;
            
            if(in_array(true, $checked, true)) return true;

            return false;
        });

        Validator::extend('mimes_multiple', function($attribute, $value, $params){
            $checked = []; 
            foreach ($value as $file):
                if(is_null($file)):
                    $checked[] = true;
                else:
                    $extension = $file->getClientOriginalExtension();
                    if(in_array($extension, $params)):
                        $checked[] = true;
                    else:
                        $checked[] = false;
                    endif;
                endif; 
            endforeach;
            
            if(in_array(false, $checked, true)) return false;

            return true;
        });

        Validator::replacer('max_file_size', function($message, $attribute, $rule, $parameters){
            return str_replace(':max_file_size', $parameters[0], $message);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
