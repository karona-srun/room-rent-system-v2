<?php

namespace App\Services;

use danog\MadelineProto\API;
use Exception;
use Illuminate\Support\Facades\Log;

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

    public function sendMessageToTelegramUser($phoneNumber, $message) {
        $MadelineProto = new API('session.madeline');

        try {
            // $MadelineProto->start();

            //$MadelineProto->phoneLogin($phoneNumber);

            // Send the message to the Telegram user
            $MadelineProto->messages->sendMessage([
                'peer' => $phoneNumber,
                'message' => $message
            ]);

            // $MadelineProto->logout();
        } catch (\danog\MadelineProto\RPCErrorException $e) {
            Log::info($e->getMessage());
            throw new Exception("Error sending message: " . $e->getMessage());
        }
    }
}