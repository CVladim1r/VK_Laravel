<?php

namespace App\Services;

use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiException;
use App\Models\Prize;

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
    protected function getPrizeAttachment($prizeId)
    {
        $prize = Prize::find($prizeId);

        if (!$prize) {
            return '';
        }
        $attachment = $prize->image_url;

        return $attachment;
    }
}
