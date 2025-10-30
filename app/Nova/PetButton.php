<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class PetButton extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\PetButton>
     */
    public static $model = \App\Models\PetButton::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'button_text';

    public static $group = 'Pet Management';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'button_text', 'button_type', 'pet_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('Button ID', 'button_id')->sortable(),
            
            BelongsTo::make('Pet', 'pet', \App\Nova\Pet::class)
                ->display('pet_name'), 
            
            Select::make('Button Type', 'button_type')
                ->options([
                    'image' => '圖片按鈕',
                    'video' => '影片按鈕',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->help('選擇按鈕類型：圖片或影片'),
            
            Text::make('Button Text', 'button_text')
                ->sortable()
                ->help('按鈕上顯示的文字'),
            
            // 根據按鈕類型顯示不同的檔案上傳欄位
            Image::make('Image File', 'media_path')
                ->disk('public')
                ->thumbnail(function () {
                    if (!$this->media_path || !$this->pet) return null;
                    $slug = $this->pet->website_slug ?? 'default';
                    return asset("storage/pets/{$slug}/image/main/button/{$this->media_path}");
                })
                ->preview(function () {
                    if (!$this->media_path || !$this->pet) return null;
                    $slug = $this->pet->website_slug ?? 'default';
                    return asset("storage/pets/{$slug}/image/main/button/{$this->media_path}");
                })
                ->download(function () {
                    if (!$this->media_path || !$this->pet) return null;
                    $slug = $this->pet->website_slug ?? 'default';
                    return asset("storage/pets/{$slug}/image/main/button/{$this->media_path}");
                })
                ->resolveUsing(function ($value, $model) {
                    return $model->button_type === 'image' ? $value : null;
                })
                ->help('上傳圖片檔案（僅圖片按鈕使用）')
                ->dependsOn('button_type', 'image'),
            
            File::make('Video File', 'media_path')
                ->disk('public')
                ->acceptedTypes('.mp4,.webm,.mov')
                ->download(function () {
                    if (!$this->media_path || !$this->pet) return null;
                    $slug = $this->pet->website_slug ?? 'default';
                    return asset("storage/pets/{$slug}/image/main/button/{$this->media_path}");
                })
                ->resolveUsing(function ($value, $model) {
                    return $model->button_type === 'video' ? $value : null;
                })
                ->showOnDetail()
                ->help('上傳影片檔案（僅影片按鈕使用）')
                ->dependsOn('button_type', 'video'),

            // 列表頁顯示影片檔名
            Text::make('Video File', 'media_path')
                ->resolveUsing(function ($value, $model) {
                    return $model->button_type === 'video' ? $value : null;
                })
                ->onlyOnIndex(),
            
            // 影片專用設定
            Select::make('Video Ratio', 'ratio')
                ->options([
                    'tall' => '長版 (tall)',
                    'long' => '寬版 (long)',
                ])
                ->displayUsingLabels()
                ->help('影片比例（僅影片按鈕使用）')
                ->dependsOn('button_type', 'video'),
            
            Boolean::make('Sound', 'sound')
                ->help('是否有聲音（僅影片按鈕使用）')
                ->dependsOn('button_type', 'video'),
            
            Boolean::make('Is Active', 'is_active')
                ->sortable()
                ->help('是否啟用此按鈕'),
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
