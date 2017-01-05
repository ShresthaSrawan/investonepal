<?php

namespace App\Http\Requests;

use App\Models\AnnouncementSubType;
use Auth;

class AnnouncementMiscFormRequest extends Request
{
    public function authorize()
    {
        if(!Auth::check()){
            return false;
        }

        return true;
    }

    public function rules()
    {
        $rules = [
            'type_id' => 'required|exists:announcement_type,id',
            'subtype_id' => 'exists:announcement_subtype,id|unique:announcement_misc,subtype_id',
            'title' => 'required',
            'description' => 'required',
        ];

        $st = $this->has('type_id') ? $anon = AnnouncementSubType::where('announcement_type_id',$this->get('type_id'))->first() : NULL;

        if(!is_null($st))  $rules['subtype_id'] = 'required|exists:announcement_subtype,id|unique:announcement_misc,subtype_id';

        if($this->isMethod('put')):
            $rules['subtype_id'] .= ','.$this->misc;
        endif;

        return $rules;
    }

    public function messages()
    {
        return [
            'type_id.required' => 'The type field is required.',
            'type_id.exists' => 'The selected type is invalid.',
            'subtype_id.required' => 'The subtype field is required.',
            'subtype_id.exists' => 'The selected subtype is invalid.',
            'subtype_id.unique' => 'The subtype has already been taken.',
        ];
    }
}
