<?php

namespace App\Services;

use danog\MadelineProto\API;
use Exception;

class MadelineService
{
    protected $API;

    public function __construct()
    {
        $this->API = new API('session.madeline');
    }

    public function login($phoneNumber)
    {
        try {
            $this->API->phoneLogin($phoneNumber);
            return 'Logged in successfully';
        } catch (\danog\MadelineProto\Exception $e) {
            return 'Login failed: ' . $e->getMessage();
        }
    }

    public function OTP($code)
    {
        try {
            $this->API->completePhoneLogin($code);
            return 'Logged in successfully';
        } catch (\danog\MadelineProto\Exception $e) {
            return 'Login failed: ' . $e->getMessage();
        }
    }

    public function sendMessage($peer, $message)
    {
        try {
            $this->API->messages->sendMessage([
                'peer' => $peer,
                'message' => $message,
            ]);
            return 'Message sent successfully';
        } catch (\danog\MadelineProto\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    function sendMessageToTelegramUser($apiId, $apiHash, $phoneNumber, $message) {
        // Create a new instance of the MadelineProto API
        $MadelineProto = new API('session.madeline');
     
        try {
            // Start the API
            $MadelineProto->start();
     
            // Login using your API ID and API hash
            //$MadelineProto->phoneLogin($phoneNumber);
     
            // Send the message to the Telegram user
            $MadelineProto->messages->sendMessage([
                'peer' => $phoneNumber,
                'message' => $message
            ]);
     
            // Logout from the API
            $MadelineProto->logout();
        } catch (\danog\MadelineProto\Exception $e) {
            throw new Exception("Error sending message: " . $e->getMessage());
        }
    }
}