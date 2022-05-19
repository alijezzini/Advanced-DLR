<?php

namespace App\Services;

use App\Models\Message;
use Carbon\Carbon;
use App\Repository\MessageRepository;
use App\Repository\BlacklistSourceRepository;
use App\Repository\SourceDestinationRepository;

class FakerService
{

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function checkBlacklistSender(): bool
    {
        $source_sender_id = BlacklistSourceRepository::getSourceBySenderId($this->message->sender_id);

        if ($source_sender_id->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function checkSenderDestination(): bool
    {
        $sender_id_destination = SourceDestinationRepository::getSenderDestination(
            $this->message->sender_id,
            $this->message->destination
        );
        if ($sender_id_destination->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function getTimeDifference(): Carbon
    {
        $old_destination = SourceDestinationRepository::getSenderDestination(
            $this->message->sender_id,
            $this->message->destination
        );
        $old_time_received = Carbon::createFromDate(
            $old_destination->time_received
        );
        $new_time_received = Carbon::createFromDate($this->message->time_received);

        $time_difference = $$old_time_received->diffInDays($new_time_received);

        return $time_difference;
    }

    public function checkFakingInterval(): bool
    {
        $time_difference = $this->getTimeDifference();
        $time_interval = MessageRepository::getTimeInterval()->time_interval;

        if ($time_difference > $time_interval) {
            return true;
        } else {
            return false;
        }
    }

    public function fakingManager()
    {
        $blacklist_sender = $this->checkBlacklistSender();
        if (!$blacklist_sender) {
            // not implemented yet
            MessagesService::sendMessage($this->message);
            return;
        }
        $sender_destination = $this->checkSenderDestination();
        if (!$sender_destination) {
            $this->message->fake = 1;
            // fake =1 
            MessageRepository::updateMessage($this->message);
            SourceDestinationRepository::insertSenderDestination($this->message);
            // not implemented yet
            // return delivered dlr response;
        } else {
            $faking_interval = $this->checkFakingInterval();
            if ($faking_interval) {
                $this->message->fake = 1;
                MessageRepository::updateMessage($this->message);
                // not implemented yet
                // return delivered dlr response;
            } else {
                // not implemented yet
                MessagesService::sendMessage($this->message);
            }
            SourceDestinationRepository::updateSenderDestination($this->message);
        }
    }
}
