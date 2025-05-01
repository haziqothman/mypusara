<?php

namespace App\Services;

class NotificationService
{
    public function sendWhatsApp($phone, $message)
    {
        try {
            // Using Twilio WhatsApp API
            $twilio = new \Twilio\Rest\Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );
            
            $twilio->messages->create(
                "whatsapp:+$phone",
                [
                    'from' => 'whatsapp:' . config('services.twilio.whatsapp_from'),
                    'body' => $message
                ]
            );
            
        } catch (\Exception $e) {
            \Log::error("WhatsApp failed to $phone: " . $e->getMessage());
            $this->sendSMS($phone, $message); // Fallback to SMS
        }
    }

    public function sendSMS($phone, $message)
    {
        try {
            // Using Twilio SMS
            $twilio = new \Twilio\Rest\Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );
            
            $twilio->messages->create(
                "+$phone",
                [
                    'from' => config('services.twilio.sms_from'),
                    'body' => $message
                ]
            );
            
        } catch (\Exception $e) {
            \Log::error("SMS failed to $phone: " . $e->getMessage());
            // Fallback to database notification
            \App\Models\AdminNotification::create([
                'phone' => $phone,
                'message' => $message,
                'method' => 'failed_whatsapp_sms'
            ]);
        }
    }
}