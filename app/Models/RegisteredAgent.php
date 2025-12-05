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
        return $this->hasMany(Company::class, 'registered_agent_id')
            ->where('registered_agent_type', RegisteredAgentType::REGISTEREDAGENT);
    }

    public function currentLoad()
    {
        return $this->companies()->count();
    }
}
