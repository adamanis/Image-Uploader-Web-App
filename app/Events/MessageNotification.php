<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Models\UploadedImage;

class MessageNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $message, $status, $uploadedImage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $message, $status = 'info', UploadedImage $uploadedImage = null)
    {
        $this->user = $user;
        $this->message = $message;
        $this->status = $status;
        $this->uploadedImage = $uploadedImage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification.'.$this->user->id);
    }
}
