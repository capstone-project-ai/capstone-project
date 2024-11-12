<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $message = Message::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        event(new MessageSent($message));

        return response()->json($message);
    }

    public function index()
    {
        return Message::all();
    }
}
