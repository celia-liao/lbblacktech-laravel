<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;

class LifeSlide extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\LifeSlide>
     */
    public static $model = \App\Models\LifeSlide::class;

    public static $group = 'Pet Management';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'life_slide_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'life_slide_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('Life Slide ID', 'life_slide_id')->sortable(),
            BelongsTo::make('Pet', 'pet', \App\Nova\Pet::class)
                ->display('pet_name'), 
            Image::make('封面照片', 'life_slide_image')
                ->disk('public')
                ->thumbnail(fn($value, $disk, $model) => $model->getLifeSlideUrl($value, 'image'))
                ->preview(fn($value, $disk, $model) => $model->getLifeSlideUrl($value, 'image'))
                ->help('上傳記憶迴廊封面照片（必填）'),
            
            File::make('媒體內容', 'life_slide_media')
                ->rules('nullable', 'mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi')
                ->help('上傳記憶迴廊媒體內容（可選圖片或影片）<br>支援格式：圖片(jpg, png, gif, webp)、影片(mp4, mov, avi)')
                ->onlyOnForms(),
            
            Text::make('媒體類型', function () {
                if (!$this->life_slide_media) {
                    return '❌ 未上傳';
                }
                
                // 根據文件擴展名判斷類型
                $extension = strtolower(pathinfo($this->life_slide_media, PATHINFO_EXTENSION));
                $videoExtensions = ['mp4', 'mov', 'avi', 'wmv', 'flv', 'webm'];
                
                if (in_array($extension, $videoExtensions)) {
                    return '🎬 影片';
                }
                return '📷 圖片';
            })->onlyOnIndex(),
            
            Text::make('媒體預覽', function () {
                if (!$this->life_slide_media) {
                    return "<div style='color:#ef4444; padding:10px; background:#fef2f2; border-radius:8px;'>
                                ❌ 尚未上傳媒體內容
                            </div>";
                }
                
                // 根據文件擴展名判斷是圖片還是影片
                $extension = strtolower(pathinfo($this->life_slide_media, PATHINFO_EXTENSION));
                $videoExtensions = ['mp4', 'mov', 'avi', 'wmv', 'flv', 'webm'];
                
                $debugInfo = "檔名: {$this->life_slide_media}<br>副檔名: {$extension}<br>";
                
                if (in_array($extension, $videoExtensions)) {
                    // 顯示影片
                    $url = $this->getLifeSlideUrl($this->life_slide_media, 'video');
                    $debugInfo .= "類型: 影片<br>URL: {$url}";
                    return "<div style='padding:10px; background:#f0fdf4; border-radius:8px;'>
                                <strong style='color:#10b981'>🎬 影片模式</strong>
                                <div style='font-size:12px; color:#666; margin-top:5px;'>{$debugInfo}</div>
                                <video width='400' controls style='border-radius:8px; margin-top:10px; display:block;'>
                                    <source src='{$url}' type='video/mp4'>
                                    您的瀏覽器不支援影片播放
                                </video>
                            </div>";
                } else {
                    // 顯示圖片
                    $url = $this->getLifeSlideUrl($this->life_slide_media, 'image');
                    $debugInfo .= "類型: 圖片<br>URL: {$url}";
                    return "<div style='padding:10px; background:#eff6ff; border-radius:8px;'>
                                <strong style='color:#3b82f6'>📷 圖片模式</strong>
                                <div style='font-size:12px; color:#666; margin-top:5px;'>{$debugInfo}</div>
                                <img src='{$url}' width='400' style='border-radius:8px; margin-top:10px; display:block;'>
                            </div>";
                }
            })->asHtml()->onlyOnDetail(),

            Boolean::make('Is Active', 'is_active')->sortable(),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
