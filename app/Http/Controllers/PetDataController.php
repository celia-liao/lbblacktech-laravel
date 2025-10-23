<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\WebsiteSetting;
use App\Models\WebsiteStyle;
use App\Models\PhotoGallery;
use App\Models\PetVideo;
use App\Models\TimelineEvent;
use App\Models\Letter;
use App\Models\LifeSlide;
use Illuminate\Http\JsonResponse;

class PetDataController extends Controller
{
    public function getPetData(string $slug): JsonResponse
    {
        $pet = Pet::where('website_slug', $slug)->first();

        if (!$pet) {
            return response()->json([
                'success' => false,
                'message' => 'Pet not found',
            ], 404, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        // 獲取相關資料
        $websiteSetting = WebsiteSetting::where('pet_id', $pet->pet_id)->first();
        $websiteStyle = WebsiteStyle::where('pet_id', $pet->pet_id)->first();
        $photoGalleries = PhotoGallery::where('pet_id', $pet->pet_id)
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();
        $petVideos = PetVideo::where('pet_id', $pet->pet_id)->where('is_active', true)->get();
        $timelineEvents = TimelineEvent::where('pet_id', $pet->pet_id)
            ->where('is_visible', true)
            ->orderBy('display_order')
            ->get();
        $letter = Letter::where('pet_id', $pet->pet_id)->first();
        $lifeSlides = LifeSlide::where('pet_id', $pet->pet_id)->where('is_active', true)->get();

        // 整理照片資料
        $photos = [
            'header' => $photoGalleries->where('photo_category', 'header')->pluck('photo_path')->toArray(),
            'bubble_small' => $photoGalleries->where('photo_category', 'bubble_small')->pluck('photo_path')->toArray(),
            'bubble_large' => $photoGalleries->where('photo_category', 'bubble_large')->pluck('photo_path')->toArray(),
        ];

        // 整理影片資料
        $videos = [
            'header' => $petVideos->where('category', 'header')->map(function($video) {
                return [
                    'video_path' => $video->video_path,
                    'category' => $video->category,
                ];
            })->toArray(),
            'bubble' => $petVideos->where('category', 'bubble')->map(function($video) {
                return [
                    'video_path' => $video->video_path,
                    'text' => $video->text,
                    'ratio' => $video->ratio,
                    'sound' => $video->sound,
                ];
            })->toArray(),
            'corridor' => $petVideos->where('category', 'corridor')->map(function($video) {
                return [
                    'video_path' => $video->video_path,
                    'text' => $video->text,
                    'ratio' => $video->ratio,
                    'sound' => $video->sound,
                ];
            })->toArray(),
        ];

        // 整理生命軌跡資料
        $timeline = $timelineEvents->map(function($event) {
            return [
                'age' => $event->age,
                'event_title' => $event->event_title,
                'event_description' => $event->event_description,
                'event_photo' => $event->event_photo,
                'background' => $event->background,
                'original_image' => $event->original_image,
                'is_ending' => $event->is_ending,
            ];
        })->toArray();

        // 整理生命軌跡資料
        $lifeSlides = $lifeSlides->map(function($slide) {
            return [
                'life_slide_image' => $slide->life_slide_image,
                'life_slide_media' => $slide->life_slide_media,
            ];
        })->toArray();

        // 組合完整資料
        $data = [
            'pet' => [
                'pet_id' => $pet->pet_id,
                'pet_name' => $pet->pet_name,
                'website_slug' => $pet->website_slug,
                'slogan' => $pet->slogan,
                'is_active' => $pet->is_active,
            ],
            'website_setting' => $websiteSetting ? [
                'target_number' => $websiteSetting->target_number,
                'duration' => $websiteSetting->duration,
                'corridor_random_image_count' => $websiteSetting->corridor_random_image_count,
                'creation_date' => $websiteSetting->creation_date,
            ] : null,
            'website_style' => $websiteStyle ? [
                'loading_color' => $websiteStyle->loading_color,
                'cover_name_color' => $websiteStyle->cover_name_color,
                'header_love_color' => $websiteStyle->header_love_color,
                'header_footprint_color' => $websiteStyle->header_footprint_color,
                'day_text_color' => $websiteStyle->day_text_color,
                'title_color' => $websiteStyle->title_color,
                'handshake_button_color' => $websiteStyle->handshake_button_color,
                'videos_button_color' => $websiteStyle->videos_button_color,
                'bubble_ball_color' => $websiteStyle->bubble_ball_color,
                'bubble_background' => $websiteStyle->bubble_background,
                'footprint_color' => $websiteStyle->footprint_color,
                'footer_background_color' => $websiteStyle->footer_background_color,
                'function_color' => $websiteStyle->function_color,
                'function_background_color' => $websiteStyle->function_background_color,
            ] : null,
            'photos' => $photos,
            'videos' => $videos,
            'timeline' => $timeline,
            'letter' => $letter ? [
                'letter_content' => $letter->letter_content,
            ] : null,
            'life_slides' => $lifeSlides,
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * 根據 pet_id 獲取寵物資料（供其他專案使用）
     * 
     * @param int $petId
     * @return JsonResponse
     */
    public function getPetDataById(int $petId): JsonResponse
    {
        try {
            // 1. 查詢寵物基本資料
            $pet = Pet::select('pet_id', 'pet_name', 'breed', 'personality', 'slogan', 'line_user_id')
                ->where('pet_id', $petId)
                ->first();

            if (!$pet) {
                return response()->json([
                    'success' => false,
                    'message' => '找不到指定的寵物資料',
                ], 404, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }

            // 2. 查詢生命軌跡（只顯示 is_visible=1 的事件，按 display_order 排序）
            $life = TimelineEvent::select('age', 'event_title as title', 'event_description as text')
                ->where('pet_id', $petId)
                ->where('is_visible', 1)
                ->orderBy('display_order')
                ->get()
                ->toArray();

            // 3. 查詢主人的信件
            $letter = Letter::select('letter_content as content')
                ->where('pet_id', $petId)
                ->first();

            // 組合並返回完整的寵物資料
            $result = [
                'name' => $pet->pet_name,                           // 寵物名字
                'breed' => $pet->breed ?: '寵物',                   // 寵物品種（從資料庫讀取）
                'persona_key' => $pet->personality ?: 'friendly',  // 性格類型（從資料庫讀取）
                'cover_slogan' => $pet->slogan ?: '',              // 主人的愛意標語
                'lifeData' => $life,                                // 生命軌跡事件列表
                'letter' => $letter ? $letter->content : ''        // 主人的信件內容
            ];

            return response()->json([
                'success' => true,
                'data' => $result,
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '查詢寵物資料時發生錯誤：' . $e->getMessage(),
            ], 500, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * 根據 line_user_id 獲取寵物ID
     * 
     * @param string $lineUserId
     * @return JsonResponse
     */
    public function getPetIdByLineUserId(string $lineUserId): JsonResponse
    {
        try {
            // 查詢寵物ID
            $pet = Pet::select('pet_id', 'pet_name', 'line_user_id')
                ->where('line_user_id', $lineUserId)
                ->first();

            if (!$pet) {
                return response()->json([
                    'success' => false,
                    'message' => '找不到對應的寵物資料',
                ], 404, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }

            // 返回寵物ID和基本資料
            $result = [
                'pet_id' => $pet->pet_id,
                'pet_name' => $pet->pet_name,
                'line_user_id' => $pet->line_user_id,
            ];

            return response()->json([
                'success' => true,
                'data' => $result,
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '查詢寵物ID時發生錯誤：' . $e->getMessage(),
            ], 500, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }
}
