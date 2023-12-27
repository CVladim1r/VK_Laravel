<?php

namespace App\Services;

use App\Models\User;

class GiftService
{
    public function sendGift($senderId, $recipientId, $giftAmount)
    {
        $sender = User::find($senderId);
        $recipient = User::find($recipientId);

        if (!$sender || $sender->votes < $giftAmount) {
            return ['success' => false, 'message' => 'Insufficient votes'];
        }

        $sender->decrement('votes', $giftAmount);
        $recipient->increment('votes', $giftAmount);
        
        return ['success' => true, 'message' => 'Gift sent successfully'];
    }
}
