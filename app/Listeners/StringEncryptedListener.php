<?php

namespace App\Listeners;

use App\Events\StringEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class StringEncryptedListener
{
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
    public function handle(StringEncrypted $event): void
    {
        Log::info('string encrypted event called', ['event str' => $event->str]);
    }
}
