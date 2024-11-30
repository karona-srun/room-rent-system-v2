<?php

namespace App\Services;

use danog\MadelineProto\API;
use Exception;
use Illuminate\Support\Facades\Log;

class MadelineService
{
    protected $MadelineProto;

    public function __construct()
    {
        $settings = [
            'app_info' => [
                'api_id' => env('TELEGRAM_API_ID'),
                'api_hash' => env('TELEGRAM_API_HASH')
            ]
        ];
         // Log the settings to debug
         Log::info('Telegram settings: ', $settings);

        $this->MadelineProto = new API('session.madeline');
    }

    public function connect()
    {
        $this->MadelineProto->start();
    }

    public function sendMessage($peer, $message)
    {
        $this->MadelineProto->messages->sendMessage(['peer' => $peer, 'message' => $message]);
    }

    public function getUsernameByPhoneNumber($phoneNumber)
    {
        try {
            $contacts = $this->MadelineProto->contacts->importContacts([
                'contacts' => [
                    ['_'=>'inputPhoneContact', 'client_id' => 0, 'phone' => $phoneNumber, 'first_name' => 'First', 'last_name' => 'Last']
                ]
            ]);

            if (!empty($contacts['users'])) {
                $user = $contacts['users'][0];
                return $user['username'] ?? null;
            }

            return null;
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, rethrow, etc.)
            return null;
        }
    }
}

