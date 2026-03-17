<?php
 
namespace App\Listeners;
 
use Laravel\Cashier\Events\WebhookReceived;
 
class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event): void
    {
        ['type' => $type, 'data' => $data] = $event->payload;
        
        switch ($type) {
            case 'invoice.payment_succeeded': {
                
            }
        }
    }
}