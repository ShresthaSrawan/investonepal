<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    protected $table = 'quarter';

    protected $fillable = ['label'];

    public static $rules = [
        'store' => [
            'label' => 'required|min:3|unique:quarter'
        ]
    ];

    public static $messages = array(
        'label.required' => 'Quarter label is required.',
        'label.min:3' => 'Quarter label must be at least 3 characters.',
        'label.unique:quarter' => 'Another quarter exists with the same label.'
    );

    public function month()
    {
        return $this->hasMany('App\Models\Month','quarter_id','id');
    }
}
