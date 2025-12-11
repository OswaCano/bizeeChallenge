<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgentCapacityAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $state;
    public int $totalCapacity;
    public int $used;
    public float $ratio;

    /**
     * Create a new message instance.
     */
    public function __construct(string $state, int $totalCapacity, int $used, float $ratio)
    {
        $this->state = $state;
        $this->totalCapacity = $totalCapacity;
        $this->used = $used;
        $this->ratio = $ratio;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Agent Capacity Alert Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.agent-capacity-alert',
            with: [
                'state' => $this->state,
                'total' => $this->totalCapacity,
                'used' => $this->used,
                'percent' => round($this->ratio * 100, 1),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
