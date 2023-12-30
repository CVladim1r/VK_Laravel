<?php

namespace App\Services;

use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App; // Добавлен импорт

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
     * Get information about the sticker pack.
     *
     * @param int $prizeId Prize ID
     * @return array|null Information about the sticker pack or null if not found
     */
    protected function getStickerPackInfo($prizeId)
    {
        // Здесь реализуйте логику получения информации о стикерпаке по его ID
        // Пример: возвращаем массив с ID стикерпака и другой информацией
        return [
            'sticker_pack_id' => 123,
            'title' => 'Название вашего стикерпака',
            'stickers' => [
                ['sticker_id' => 456, 'title' => 'Стикер 1'],
                ['sticker_id' => 457, 'title' => 'Стикер 2'],
                // Другие стикеры стикерпака...
            ],
        ];
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
        $ownerId = '-' . $groupId;
        $fromGroup = 1;
        $attachments = $this->getPrizeAttachment($prizeId);

        try {
            $response = $this->vk->wall()->post($this->accessToken, [
                'owner_id' => $ownerId,
                'from_group' => $fromGroup,
                'message' => $message,
                'attachments' => $attachments,
                'user_id' => $winnerId,
                'v' => $this->apiVersion,
            ]);

            if (isset($response['response'])) {
                return $response;
            } else {
                return ['error' => 'Unexpected VK API response: ' . json_encode($response)];
            }
        } catch (VKApiException $e) {
            \Log::warning('VK API Error: ' . $e->getMessage());
            return ['error' => 'VK API Error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            \Log::error('Error publishing contest results: ' . $e->getMessage());
            return ['error' => 'An error occurred while publishing contest results.'];
        }
    }


    /**
     * Get attachment string for the prize (sticker pack).
     *
     * @param int $prizeId Prize ID
     * @return string Attachment string for the prize (sticker pack)
     */
    public function getPrizeAttachment($prizeId)
    {
        $stickerPackInfo = $this->getStickerPackInfo($prizeId);

        if ($stickerPackInfo) {
            // Создаем строку для прикрепления стикерпака
            $attachment = "sticker_pack{$stickerPackInfo['sticker_pack_id']}";

            // Добавляем информацию о стикерах, если она доступна
            if (isset($stickerPackInfo['stickers']) && is_array($stickerPackInfo['stickers'])) {
                foreach ($stickerPackInfo['stickers'] as $sticker) {
                    $attachment .= "_{$sticker['sticker_id']}";
                }
            }

            return $attachment;
        }

        // Возвращаем пустую строку или другой формат приза, если что-то пошло не так
        return '';
    }

    /**
     * Give votes to the winner.
     *
     * @param int $userId Winner's ID
     * @return array Result of giving votes
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

        $response = Http::post('https://api.vk.com/method/likes.add', $params);

        $result = $response->json();

        if (isset($result['response'])) {
            return ['success' => true, 'message' => 'Голоса успешно начислены!'];
        } else {
            return ['success' => false, 'message' => 'Ошибка при начислении голосов: ' . json_encode($result)];
        }
    }

    /**
     * Register the VkApiService instance in the container.
     *
     * @return VkApiService
     */
    public function register()
    {
        App::singleton(VkApiService::class, function ($app) {
            $vkApiClient = new VKApiClient(); // Use the correct namespace for your VKApiClient
            $accessToken = 'your_actual_vk_access_token';
            $apiVersion = '5.199';

            return new VkApiService($vkApiClient, $accessToken, $apiVersion);
        });
    }

    public function giveStickerToWinner($userId, $prizeId)
    {
        $attachment = $this->getPrizeAttachment($prizeId);

        $params = [
            'user_id' => $userId,
            'message' => 'Поздравляем с победой!',
            'attachment' => $attachment,
            'random_id' => uniqid(),
            'access_token' => $this->accessToken,
            'v' => $this->apiVersion,
        ];

        try {
            $response = $this->vk->messages()->send($params);
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
