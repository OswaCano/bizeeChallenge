<?php

namespace App\Models;

use App\Enums\RegisteredAgentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'state',
        'name',
        'email',
        'capacity'
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_assigment');
    }

    public function currentLoad()
    {
        return $this->companies()->count();
    }


}
