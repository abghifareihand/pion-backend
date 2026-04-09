<?php

namespace App\Services;

use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    /**
     * Kirim notifikasi ke satu token
     */
    public function sendToToken(string $token, string $title, string $body, array $data = []): void
    {
        try {
            $message = CloudMessage::fromArray([
                'token' => $token,
                'data'  => array_merge($data, [
                    'title' => $title,
                    'body'  => $body,
                ]),
                'android' => [
                    'priority' => 'high',
                ],
            ]);
            Firebase::messaging()->send($message);
        } catch (\Exception $e) {
            Log::error("FCM Send Error: " . $e->getMessage());
        }
    }

    /**
     * Kirim notifikasi ke banyak token
     */
    public function sendToTokens(array $tokens, string $title, string $body, array $data = []): void
    {
        // 🛡️ Failsafe: Ensure only unique tokens are processed
        $uniqueTokens = array_unique($tokens);

        foreach ($uniqueTokens as $token) {
            $this->sendToToken($token, $title, $body, $data);
        }
    }
}
