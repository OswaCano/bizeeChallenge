<?php

namespace App\Listeners;

use App\Events\RegisteredAgentAssigned;
use App\Mail\RegisteredAgentAssignedMail;
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

        $agent = $company->registered_agent();

        if (! $agent || empty($agent->email)) {
            return;
        }

        Mail::to($agent->email)->queue(new RegisteredAgentAssignedMail($company));
    }
}
