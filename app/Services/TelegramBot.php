<?php

namespace App\Services;

use App\Models\Apartment;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\InputMedia\InputMediaDocument;
use Telegram\Bot\FileUpload\InputMedia;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\InputMedia\InputMedia as InputMediaInputMedia;
use GuzzleHttp\Client;

class TelegramBot
{

    protected $botToken;
    protected $client;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->client = new Client();
    }

    public function sendMessageByPhoneNumber($phoneNumber, $message)
    {
        // Here you would typically resolve the user ID by phone number using your own logic
        $chatId = $this->getChatIdByPhoneNumber($phoneNumber);

        if ($chatId) {
            return $this->sendMessage($chatId, $message);
        }

        return false;
    }

    private function getChatIdByPhoneNumber($phoneNumber)
    {
        // This function should implement the logic to resolve a phone number to a chat ID
        // For this example, it will return a hardcoded chat ID
        // You need to implement the actual resolution logic based on your user base and storage

        // Example hardcoded chat ID
        return '+85585773007'; // Replace with actual logic
    }

    private function sendMessage($chatId, $message)
    {

        $webhookUrl = url('/telegram/webhook');

        $client = new \GuzzleHttp\Client();
        $response = $client->post("https://api.telegram.org/bot{$this->botToken}/setWebhook", [
            'form_params' => [
                'url' => $webhookUrl,
            ],
        ]);

        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        $response = $this->client->post($url, [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $message,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function listGroup()
    {
        $listGroup = [];
        // $apart = Apartment::find(Auth::user()->apartment_id);
        // Telegram::setAccessToken($apart->token);
        // $response = Telegram::getUpdates();
        // for ($i = 0; $i < count($response); $i++) {
        //     if ($response[$i]->my_chat_member != "") {
        //         $listGroup[$i] = $response[$i]->my_chat_member->chat;
        //     }
        // }

        return $listGroup;
    }

    public function sendMessageText($groupId, $message)
    {
        Telegram::setTimeOut(30);
        $apart = Apartment::find(Auth::user()->apartment_id);
        Telegram::setAccessToken($apart->token);
        $response = Telegram::sendMessage([
            'chat_id' => $groupId,
            'text' => $message,
        ]);

        return $response;
    }

    public function editMessageText($groupId, $messageId, $message)
    {
        $apart = Apartment::find(Auth::user()->apartment_id);
        Telegram::setAccessToken($apart->token);
        Telegram::editMessageText([
            'chat_id' => $groupId,
            'message_id' => $messageId,
            'text' => $message,
        ]);
    }

    public function deleteMessageText($groupId, $messageId)
    {
        Telegram::deleteMessage([
            'chat_id' => $groupId,
            'message_id' => $messageId,
        ]);
    }

    public function sendMessagePhoto($groupId, $path, $message)
    {
        Telegram::setTimeOut(30);
        $apart = Apartment::find(Auth::user()->apartment_id);
        Telegram::setAccessToken($apart->token);
        $response = Telegram::sendPhoto([
            'chat_id' => $groupId[0],
            'photo' => InputFile::create(public_path() . '/' . $path . ".jpg"),
            'caption' => $message,
            'parse_mode' => 'html',
            'text' => $message,
        ]);

        return $response;
    }

    public function editMessagePhoto($groupId, $messageId, $message)
    {
    }

    public function deleteMessagePhoto($groupId, $messageId)
    {
        $apart = Apartment::find(Auth::user()->apartment_id);
        Telegram::setAccessToken($apart->token);
        Telegram::deleteMessage([
            'chat_id' => $groupId,
            'message_id' => $messageId,
        ]);
    }

    public function sendMessageGroupPhone($groupId, $path, $message)
    {
        $apart = Apartment::find(Auth::user()->apartment_id);
        Telegram::setAccessToken($apart->token);
        $photo1 = InputMediaInputMedia::createPhoto([
            'type' => 'photo',
            'media' => InputFile::create(public_path() . '/' . $path . ".jpg"),
            'caption' => $message,
        ]);

        $photo2 = InputMediaInputMedia::createPhoto([
            'type' => 'photo',
            'media' => InputFile::create(public_path() . "/QRcode.png"),
            'caption' => 'QR Code ស្កេនដើម្បីទូទាត់វិក័យប័ត្រ',
            'has_spoiler' => true
        ]);

        $response = Telegram::sendMediaGroup([
            'chat_id' => $groupId[0],
            'media' => [
                $photo1,
                $photo2,
            ],
            'caption_entities' => [
                'phone_number' => '+85586773007'
            ]
        ]);

        if ($response->isOk()) {
            return $response;
        } else {
            // Failed to send media group
            return "Failed to send media group: " . $response->getDescription();
        }
    }
}
