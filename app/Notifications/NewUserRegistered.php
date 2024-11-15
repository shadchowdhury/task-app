<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewUserRegistered extends Notification
{
    use Queueable;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }


    // public function via(object $notifiable): array
    // {
    //     return ['mail'];
    // }

     // Specify the notification should be broadcasted
     public function via($notifiable)
     {
         return ['broadcast'];
     }

     // Create the broadcast message
     public function toBroadcast($notifiable)
     {
         return new BroadcastMessage([
             'message' => "New user registered: {$this->user->name} ({$this->user->email}) at " . now()->format('h:i A'),
         ]);
     }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
