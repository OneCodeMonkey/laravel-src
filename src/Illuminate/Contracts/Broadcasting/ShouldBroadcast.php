<?php

namespace Illuminate\Contracts\Broadcasting;

interface ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Contracts\Broadcasting\Channel[]
     */
    public function broadcastOn();
}
