<?php

namespace App\Http\Controllers;

use App\Enums\RegisteredAgentType;
use App\Events\RegisteredAgentAssigned;
use App\Models\Company;
use App\Models\RegisteredAgent;
use Illuminate\Http\Request;

class RegisteredAgentController extends Controller
{

    public function updateAgent(Request $request)
    {

        $data = $request->validate([
            'use_service' => 'required|boolean',
            'company_id' => 'required|exists:companies,id',
        ]);

        $company = Company::where("id", $data["company_id"])->first();

        $user = auth()->user();

        if($user->id != $company->user_id){
            return response("Unauthorized", 403);
        }

        if (!$data['use_service']) {
            // assign the user as their own registered agent
            $company->update([
                'registered_agent_type' => RegisteredAgentType::USER,
                'registered_agent_id' => $user->id,
            ]);

            return $company;
        }

        // use the registered agent
        $agents = RegisteredAgent::where('state', $company->state)->get();

        if ($agents->isEmpty()) {
            return response()->json([
                'error' => 'No registered agents available in this state'
            ], 422);
        }

        // calculate the current load
        $agents = $agents->map(function ($agent) {
            $agent->load = Company::where('registered_agent_type', RegisteredAgentType::REGISTEREDAGENT)
                ->where('registered_agent_id', $agent->id)
                ->count();
            return $agent;
        });

        $agents = $agents->filter(fn($a) => $a->load < ($a->capacity * 0.9));

        if ($agents->isEmpty()) {
            return response()->json([
                'error' => 'Agents without sufficient capacity'
            ], 422);
        }

        $agent = $agents->sortBy('load')->first();

        $company->update([
            'registered_agent_type' => RegisteredAgentType::REGISTEREDAGENT,
            'registered_agent_id' => $agent->id,
        ]);

        event(new RegisteredAgentAssigned($company));

        return response()->json([
            'company' => $company,
        ],200);
    }

    public function checkCapacity($state)
    {

        $agents = RegisteredAgent::where('state', $state)->get();

        if ($agents->isEmpty()) {
            return ['available' => false];
        }

        foreach ($agents as $agent) {
            $load = Company::where('registered_agent_type', RegisteredAgentType::REGISTEREDAGENT)
                ->where('registered_agent_id', $agent->id)
                ->count();

            if ($load < ($agent->capacity * 0.9)) {
                return ['available' => true];
            }
        }

        return ['available' => false];
    }
}
