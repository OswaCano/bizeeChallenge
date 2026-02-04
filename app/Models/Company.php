<?php

namespace App\Models;

use App\Enums\RegisteredAgentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'state',
        'registered_agent_type',
        'registered_agent_id'
    ];

    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function registered_agents()
    {
        return $this->morphedByMany(RegisteredAgent::class, 'company_assignment');
    }
}
