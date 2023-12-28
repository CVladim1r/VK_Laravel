<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contest;
use App\Models\Prize;
use App\Models\Task;
use App\Models\PublicModel;
use App\Models\ContestModel;
use App\Services\VkApiService;

class ContestController extends Controller
{
    private VkApiService $vkApiService;

    public function __construct(VkApiService $vkApiService)
    {
        $this->vkApiService = $vkApiService;
    }

    public function index()
    {
        $contests = ContestModel::all();
        return view('contests.index', compact('contests'));
    }

    public function store(Request $request)
    {
        // Validate data
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'text' => 'required',
            'draw_time' => 'required|date',
            'public_id' => 'required|exists:publics,id',
        ]);

        // Upload image
        $imagePath = $request->file('image')->store('images');

        // Create a new record in the database
        $contest = ContestModel::create([
            'image' => $imagePath,
            'text' => $request->input('text'),
            'draw_time' => now()->parse($request->input('draw_time')),
            'public_id' => $request->input('public_id'),
        ]);

        // Get information about the created contest
        $contestId = $contest->id;
        $contestMessage = $contest->text;
        $contestLink = route('contests.show', $contestId);
        // Send a post to the VK group
        $public = PublicModel::find($request->input('public_id'));
        $groupId = $public->vk_id;
        // Replace these placeholders with your actual VK Group Token and VK API Version
        $yourVkGroupToken = 'your_actual_vk_group_token';
        $yourVkApiVersion = '5.199';

        // Instantiate VkApiService with the required arguments
        $vkApiClient = new \VK\Client\VKApiClient(); // Use the correct namespace for your VKApiClient
        $vkApiService = new VkApiService($vkApiClient, $yourVkGroupToken, $yourVkApiVersion);

        $response = $vkApiService->publishContestResults($groupId, $contestMessage, $contestId, $request->input('prize_id'));

        // Redirect or other logic based on the result
        return redirect()->route('contests.index')->with('success', 'Contest added successfully');
    }

    public function edit($id)
    {
        $contest = ContestModel::find($id);
        $publics = PublicModel::all();
        return view('contests.edit', compact('contest', 'publics'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif',
            'text' => 'required',
            'draw_time' => 'required|date',
            'public_id' => 'required|max:255',
        ]);

        $contest = ContestModel::find($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images');
            $contest->image = $imagePath;
        }

        $contest->text = $request->input('text');
        $contest->draw_time = now()->parse($request->input('draw_time'));
        $contest->public_id = $request->input('public_id');
        $contest->save();

        return redirect()->route('contests.index')->with('success', 'Contest updated successfully');
    }

    public function destroy($id)
    {
        $contest = ContestModel::find($id);
        $contest->delete();

        return redirect()->route('contests.index')->with('success', 'Contest deleted successfully');
    }

    public function publishContestResults($groupId, $message, $winnerId, $stickerId)
    {
        $prize = Prize::find($stickerId);

        // Проверка наличия приза
        if (!$prize) {
            return redirect()->route('contests.index')->with('error', 'Invalid prize selected');
        }

        // Получение идентификатора победителя
        $winnerUserId = ContestModel::find($winnerId)->winner->user_id;
        $votesToGive = $prize->value; 
        $result = $this->vkApiService->giveVotesToWinner($winnerUserId, $votesToGive);

        if (!$result['success']) {
            return redirect()->route('contests.index')->with('error', 'Error giving votes: ' . $result['message']);
        }

        $response = $this->vkApiService->giveStickerToWinner($winnerUserId, $prize->sticker_id);

        // Обработка результата отправки стикера
        if (isset($response['response'])) {
            return redirect()->route('contests.index')->with('success', 'Contest added successfully');
        } else {
            return redirect()->route('contests.index')->with('error', 'Error sending sticker: ' . json_encode($response));
        }
    }

    public function create()
    {
        return view('contests.create');
    }
}
