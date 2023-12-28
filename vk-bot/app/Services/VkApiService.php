<?php

namespace App\Services;

use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiException;
use App\Models\Prize;
use Illuminate\Support\Facades\Http;

class VkApiService
{
    protected VKApiClient $vk;
    protected string $accessToken;
    protected string $apiVersion;

    public function __construct(VKApiClient $vk, $accessToken, $apiVersion)
    {
        $this->vk = $vk;
        $this->accessToken = $accessToken;
        $this->apiVersion = $apiVersion;

    }

    /**
     * Create a post with contest results and send the prize to the winner.
     *
     * @param int $groupId ID of the VK group
     * @param string $message Message text
     * @param int $winnerId Winner's ID
     * @param int $prizeId Prize ID
     * @return array Response from VK API
     */
    public function publishContestResults($groupId, $message, $winnerId, $prizeId)
    {
        // Prepare data for the VK API request
        $params = [
            'owner_id' => '-' . $groupId,
            'from_group' => 1,
            'message' => $message,
            'attachments' => $this->getPrizeAttachment($prizeId),
            'user_id' => $winnerId,
            'access_token' => $this->accessToken,
            'v' => $this->apiVersion,
        ];

        try {
            $response = $this->vk->wall()->post($params);
            return $response;
        } catch (VKApiException $e) {
            \Log::warning('VK API Error: ' . $e->getMessage());
            return ['error' => 'VK API Error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            \Log::error('Error publishing contest results: ' . $e->getMessage());
            return ['error' => 'An error occurred while publishing contest results.'];
        }
    }

    /**
     * Get attachment string for the prize.
     *
     * @param int $prizeId Prize ID
     * @return string Attachment string for the prize
     */
    public function giveVotesToWinner($userId)
    {
        $params = [
            'access_token' => $this->accessToken,
            'type' => 'post',
            'owner_id' => $userId,
            'item_id' => 1,
            'v' => $this->apiVersion,
        ];

        $response = Http::get('https://api.vk.com/method/likes.add', $params);

        $result = $response->json();

        if (isset($result['response'])) {
            return ['success' => true, 'message' => 'Голоса успешно начислены!'];
        } else {
            return ['success' => false, 'message' => 'Ошибка при начислении голосов: ' . json_encode($result)];
        }
    }

    public function giveStickerToWinner($userId, $stickerId)
    {
        $params = [
            'user_id' => $userId,
            'sticker_id' => $stickerId,
            'random_id' => uniqid(), // Уникальный идентификатор для предотвращения повторной отправки
            'access_token' => $this->accessToken,
            'v' => $this->apiVersion,
        ];

        try {
            $response = $this->vk->messages()->sendSticker($params);
            return $response;
        } catch (VKApiException $e) {
            \Log::warning('VK API Error: ' . $e->getMessage());
            return ['error' => 'VK API Error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            \Log::error('Error sending sticker: ' . $e->getMessage());
            return ['error' => 'An error occurred while sending sticker.'];
        }
    }

    /**
     * Send a sticker pack to the user.
     *
     * @param int $userId ID of the VK user
     * @param int $stickerPackId ID or information about the sticker pack
     * @return array Result of sending the sticker pack
     */
    public function sendStickerPack($userId, $stickerPackId)
    {
        $params = [
            'user_id' => $userId,
            'sticker_pack' => $stickerPackId,
            'access_token' => $this->accessToken,
            'v' => $this->apiVersion,
        ];

        try {
            $response = Http::get('https://api.vk.com/method/gifts.sendStickerPack', $params);
            $result = $response->json();

            if (isset($result['response'])) {
                return ['success' => true, 'message' => 'Sticker pack sent successfully'];
            } else {
                return ['success' => false, 'message' => 'Error sending sticker pack: ' . json_encode($result)];
            }
        } catch (\Exception $e) {
            \Log::error('Error sending sticker pack: ' . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred while sending the sticker pack.'];
        }
    }
}
