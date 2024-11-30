<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MadelineService;

class TelegramController extends Controller
{
    protected $telegramService;

    public function __construct(MadelineService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function sendMessage(Request $request)
    {
        $peer = $request->input('peer');
        $message = $request->input('message');

        $this->telegramService->connect();
        $this->telegramService->sendMessage($peer, $message);

        return response()->json(['status' => 'Message sent']);
    }

    public function getUsernameByPhoneNumber(Request $request)
    {
        $phoneNumber ='+85585773007';

        $this->telegramService->connect();
        $username = $this->telegramService->getUsernameByPhoneNumber($phoneNumber);

        return response()->json(['username' => $username]);
    }
}

