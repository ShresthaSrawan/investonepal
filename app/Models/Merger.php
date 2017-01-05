<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merger extends Model
{
    protected $fillable = [
        'company_id',
        'companies',
        'remarks',
        'loi_date',
        'deadline_date',
        'mou_date',
        'application_date',
        'approved_date',
        'join_transaction_date',
        'swap_ratio',
        'trading',
        'type',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
