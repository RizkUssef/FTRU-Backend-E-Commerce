<?php

namespace App\Listeners;

use App\Events\PageVisited;
use App\Models\Visitor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncrementVisitorCount
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
    public function handle(PageVisited $event): void
    {
        $get_count = Visitor::where("id",1)->first();
        $newcount = $event->count + 1;
        $get_count->updateOrCreate(["id"=>1],[
            "count"=>$newcount
        ]);
    }
}
