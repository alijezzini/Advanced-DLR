<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repository\MessageRepository;
use Illuminate\Support\Facades\Http;

class MessagesService
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public static function sendMessage()
    {
    }

    public function getDeliveryStatus(Request $request)
    {
        $message = MessageRepository::getMessageById($request->message_id);
        if (!$message) {
            return [
                'status' => 'Message Id was not found!'
            ];
        } else {
            return [
                'message_id' => $message[0]->message_id,
                'delivery_status' => $message[0]->status,
            ];
        }
    }

    public function generateTerminatorId(): string
    {
        return Str::uuid();
    }

    public function returnDeliveryStatus()
    {
        // create getConnectionId method from gatewayConnections service
        $connection_id = "";
        $message_id = $this->message->terminaton_message_id;
        $status = "";
        $update_dlr = Http::post(
            "https://httpsmsc02.montymobile.com/HTTP/api/Vendor/DLRListenerBasic?" .
                "ConnectionId={$connection_id}&MessageId={$message_id}&Status={$status}"
        );
    }
}
