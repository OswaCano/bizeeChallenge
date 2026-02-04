<?php

namespace App\Listeners;

use App\Events\RegisteredAgentAssigned;
use App\Mail\RegisteredAgentAssignedMail;
use App\Models\RegisteredAgent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegisteredAgentAssignedEmail implements ShouldQueue
{
    use InteractsWithQueue;
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

        $agent_id = $company->registered_agent_id;

        $agent = RegisteredAgent::find($agent_id);

        if (!$agent || empty($agent->email)) {
            return;
        }

        Mail::to($agent->email)->queue(new RegisteredAgentAssignedMail($company));
    }
}
