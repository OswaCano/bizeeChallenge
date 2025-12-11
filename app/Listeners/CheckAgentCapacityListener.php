<?php

namespace App\Listeners;

use App\Enums\RegisteredAgentType;
use App\Events\RegisteredAgentAssigned;
use App\Mail\AgentCapacityAlertMail;
use App\Models\Company;
use App\Models\RegisteredAgent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class CheckAgentCapacityListener implements ShouldQueue
{
    use InteractsWithQueue;

    private string $adminEmail = 'admin@bizee.test';
    private float $agentCapacity = 0.9;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisteredAgentAssigned $event): void
    {
        $company = $event->company;
        $state = $company->state;

        $totalCapacity = RegisteredAgent::where('state', $state)->sum('capacity');

        $used = Company::where('state', $state)
            ->where('registered_agent_type', RegisteredAgentType::REGISTEREDAGENT)
            ->count();

        if ($totalCapacity <= 0) {
            return;
        }

        $ratio = $used/$totalCapacity;

        $cacheKey = "agent_capacity_notified:{$state}";

        if ($ratio < $this->agentCapacity) {
            Mail::to($this->adminEmail)->queue(new AgentCapacityAlertMail($state, $totalCapacity, $used, $ratio));
            Cache::put($cacheKey, true);
        }
        else {
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
        }
    }
}
