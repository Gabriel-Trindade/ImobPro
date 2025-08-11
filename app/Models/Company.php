<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'trade_name',
        'registration_number',
    ];

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function contacts()
    {
        return $this->hasMany(CompanyContact::class);
    }

    public function address()
    {
        return $this->hasOne(CompanyAddress::class);
    }
}
