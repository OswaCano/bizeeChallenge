<?php

namespace App\Http\Controllers;

use App\Enums\RegisteredAgentType;
use App\Models\Company;
use App\Models\RegisteredAgent;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:2'],
            'use_service' => 'required|boolean',
        ]);

        $user = auth()->user();

        //case 0|false without registered agent
        if (!$data['use_service']) {
            return Company::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'state' => $data['state'],
                'registered_agent_type' => RegisteredAgentType::USER->value,
                'registered_agent_id' => null,
            ]);
        }

        //case 1|true using registered agent
        $agents = RegisteredAgent::where('state', $data['state'])->get();

        if ($agents->isEmpty())
            return response()->json([
                'error' => 'No registered agents available in this state'
            ], 422);

        //calculate the load for each agent
        $agents = $agents->map(function ($agent) {

            $agent->load = Company::where('registered_agent_type', RegisteredAgentType::REGISTEREDAGENT->value)
                ->where('registered_agent_id', $agent->id)
                ->count();

            return $agent;
        });

        //filter agents that have less load than capacity
        $agents = $agents->filter(fn($agent) => $agent->load < $agent->capacity);

        if ($agents->isEmpty())
            return response()->json([
                'error' => 'All registered agents are currently loaded. Try again later'
            ], 422);

        $agents = $agents->sortByDesc('load');
        $agent = $agents->first();

        return Company::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'state' => $data['state'],
            'registered_agent_type' => RegisteredAgentType::REGISTEREDAGENT->value,
            'registered_agent_id' => $agent->id,
        ]);
    }
}
