<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{
    protected $fillable = [
        'company_id',
        'email',
        'phone',
        'instagram',
        'facebook',
        'olx',
        'website',
        'type', // 'Sales, Support, Finances'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
