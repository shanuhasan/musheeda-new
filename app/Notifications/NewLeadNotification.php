<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Lead;

class NewLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $lead;

    /**
     * Create a new notification instance.
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Lead Submitted: ' . $this->lead->source)
            ->line('A new lead has been submitted on the website.')
            ->line('Name: ' . $this->lead->name)
            ->line('Email: ' . $this->lead->email)
            ->line('Phone: ' . $this->lead->phone)
            ->action('View Lead', route('admin.leads.show', $this->lead->id))
            ->line('Please follow up accordingly.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'lead_id' => $this->lead->id,
            'source' => $this->lead->source,
            'name' => $this->lead->name,
        ];
    }
}
