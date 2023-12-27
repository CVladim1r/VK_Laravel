<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GiftService;

class GiftController extends Controller
{
    public function gift(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required',
            'gift_amount' => 'required|integer|min:1',
        ]);

        $giftService = new GiftService();
        $result = $giftService->sendGift(auth()->id(), $request->input('recipient_id'), $request->input('gift_amount'));
        return response()->json($result);
    }
}
