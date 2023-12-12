<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

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

    public function sendMessagePhoto($groupId, $path ,$message)
    {
        Telegram::setTimeOut(30);
        $response = Telegram::sendPhoto([
            'chat_id' => $groupId[0],
            'photo' => InputFile::create(public_path().'/'. $path.".jpg"),
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
}