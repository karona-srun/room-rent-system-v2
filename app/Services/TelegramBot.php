<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\InputMedia\InputMediaDocument;
use Telegram\Bot\FileUpload\InputMedia;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\InputMedia\InputMedia as InputMediaInputMedia;

class TelegramBot
{
    public function listGroup()
    {
        $response = Telegram::getUpdates();
        for ($i = 0; $i < count($response); $i++) {
            if ($response[$i]->my_chat_member != "") {
                $listGroup[$i] = $response[$i]->my_chat_member->chat;
            }
        }

        return $listGroup;
    }

    public function sendMessageText($groupId, $message)
    {
        Telegram::setTimeOut(30);
        $response = Telegram::sendMessage([
            'chat_id' => $groupId,
            'text' => $message,
        ]);

        return $response;
    }

    public function editMessageText($groupId, $messageId, $message)
    {
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
        Telegram::deleteMessage([
            'chat_id' => $groupId,
            'message_id' => $messageId,
        ]);
    }

    public function sendMessageGroupPhone($groupId, $path, $message)
    {
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
                'phone_number' => '+85596773007'
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
