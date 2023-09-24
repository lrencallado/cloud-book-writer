<?php

namespace App\Events;

use App\Models\Section;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SectionContentUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $section;

    /**
     * Create a new event instance.
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('book.section.' . $this->section->id),
        ];
    }
}
