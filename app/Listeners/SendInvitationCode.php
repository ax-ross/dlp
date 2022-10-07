<?php

namespace App\Listeners;

use App\Events\InvitationCreated;
use App\Services\InvitationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInvitationCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(protected InvitationService $invitationService)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(InvitationCreated $event)
    {
        $this->invitationService->sendInvitation($event->from, $event->to, $event->code);
    }
}
