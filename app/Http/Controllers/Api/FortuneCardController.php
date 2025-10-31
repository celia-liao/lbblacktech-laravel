<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\LifeSlide;
use App\Models\TimelineEvent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FortuneCardController extends Controller
{
    /**
     * 獲取寵物的隨機占卜卡資料
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getRandomFortuneCard(Request $request): JsonResponse
    {
        $petId = $request->input('pet_id');
        $lineUserId = $request->input('line_user_id');

        // 如果沒有提供pet_id，嘗試通過line_user_id查找
        if (!$petId && $lineUserId) {
            $pet = Pet::where('line_user_id', $lineUserId)->first();
            if ($pet) {
                $petId = $pet->pet_id;
            }
        }

        if (!$petId) {
            return response()->json([
                'success' => false,
                'message' => '請提供寵物ID或LINE用戶ID'
            ], 400);
        }

        // 獲取寵物資訊
        $pet = Pet::find($petId);
        if (!$pet) {
            return response()->json([
                'success' => false,
                'message' => '找不到指定的寵物'
            ], 404);
        }

        // 獲取覆蓋圖 隨機的
        $coverImage = $this->getRandomCoverImage();

        // 獲取寵物圖片（優先使用bubble_small，如果沒有則使用header）
        $petImage = $this->getPetImage($pet);

        return response()->json([
            'success' => true,
            'data' => [
                'pet_id' => $pet->pet_id,
                'pet_name' => $pet->pet_name,
                'pet_image' => $petImage,
                'cover_image' => $coverImage,
            ]
        ]);
    }

    /**
     * 隨機獲取覆蓋圖 URL
     * 
     * @return string|null
     */
    private function getRandomCoverImage(): ?string
    {
        $fgDir = public_path('assets/images/fortune_bg');
        $fgCandidates = glob($fgDir . '/*.png') ?: [];
        
        if (count($fgCandidates) === 0) {
            return null;
        }
        
        // 隨機選擇一張圖片
        $selectedPath = $fgCandidates[array_rand($fgCandidates)];
        
        // 從完整路徑中提取檔案名稱
        $fileName = basename($selectedPath);
        
        // 返回完整的公開 URL
        return asset("assets/images/fortune_bg/{$fileName}");
    }

    /**
     * 獲取寵物圖片
     * 
     * @param Pet $pet
     * @return string|null
     */
    private function getPetImage(Pet $pet): ?string
    {
        // 優先從LifeSlide獲取圖片
        $lifeSlide = LifeSlide::where('pet_id', $pet->pet_id)
            ->where('is_active', true)
            ->whereNotNull('life_slide_image')
            ->inRandomOrder()
            ->first();

        if ($lifeSlide && $lifeSlide->life_slide_image) {
            return $lifeSlide->getLifeSlideUrl($lifeSlide->life_slide_image, 'cover');
        }

        // 如果沒有LifeSlide圖片，從TimelineEvent的original_image獲取
        $timelineEventOriginal = TimelineEvent::where('pet_id', $pet->pet_id)
            ->where('is_visible', true)
            ->whereNotNull('original_image')
            ->inRandomOrder()
            ->first();

        if ($timelineEventOriginal && $timelineEventOriginal->original_image) {
            return $timelineEventOriginal->getPetImageUrl($timelineEventOriginal->original_image, 'original');
        }

        // 如果都沒有，返回null
        return null;
    }
}
