<?php

namespace App\Mails;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerSellerMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;    

    public Message $messageData;

    public function __construct(Message $message)
    {
        $this->messageData = $message;
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->messageData->subject,
            from: new Address(
                $this->messageData->from_email,
                $this->messageData->from_name
            ),
            to: [
                new Address(
                    $this->messageData->to_mail,
                    $this->messageData->to_name
                )
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.message',
            with: [
                'content' => $this->messageData->content
            ]
        );
    }
}