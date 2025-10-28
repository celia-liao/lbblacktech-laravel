<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\HasMany;

class Pet extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Pet>
     */
    public static $model = \App\Models\Pet::class;

    public static $group = 'Pet Management';
    
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'pet_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'pet_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('Pet ID', 'pet_id')->sortable(),
            Text::make('Pet Name', 'pet_name')
                ->sortable()
                ->help('輸入寵物名稱'),
            Text::make('Breed', 'breed')
                ->sortable()
                ->help('輸入寵物品種'),
            Text::make('Website Slug', 'website_slug')
                ->sortable()
                ->help('輸入網站識別碼'),
            Text::make('LINE User ID', 'line_user_id')
                ->sortable()
                ->help('輸入LINE用戶ID'),
            Select::make('Personality', 'personality')
                ->options([
                    'sunny' => '☀️ 陽光型 - 開朗活潑忠誠樂觀',
                    'foodie' => '🍖 吃貨型 - 貪吃可愛撒嬌',
                    'tsundere' => '😼 傲嬌型 - 外冷內熱',
                    'easygoing' => '🌸 隨和型 - 溫柔穩重（預設）',
                    'otaku' => '🏠 宅宅型 - 宅黏人依賴主人',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->help('選擇寵物個性類型，影響LINE聊天機器人的說話方式'),
            Text::make('Slogan', 'slogan')
                ->sortable()
                ->help('輸入給毛孩的一句話, 若要換行顯示請輸入"&lt;br&gt;"'),
            Boolean::make('Is Active', 'is_active')
                ->sortable()
                ->help('勾選是否啟用網站'),

            // ⭐ 掛載 Letter
            HasOne::make('Letter', 'letter', \App\Nova\Letter::class),

            // ⭐ 掛載 Website Setting
            HasOne::make('Website Setting', 'websiteSetting', \App\Nova\WebsiteSetting::class),

            // ⭐ 掛載 Website Style
            HasOne::make('Website Style', 'websiteStyle', \App\Nova\WebsiteStyle::class),

            // ⭐ 掛載 Timeline Event
            HasMany::make('Timeline Event', 'timelineEvents', \App\Nova\TimelineEvent::class),
        
            // ⭐ 掛載 Photo Gallery
            HasMany::make('Photo Gallery', 'photoGalleries', \App\Nova\PhotoGallery::class),

            // ⭐ 掛載 Life Slide
            HasMany::make('Life Slide', 'lifeSlides', \App\Nova\LifeSlide::class),
       
            // ⭐ 掛載 Pet Video
            HasMany::make('Pet Video', 'petVideos', \App\Nova\PetVideo::class),

            // ⭐ 掛載 Pet Button
            HasMany::make('Pet Button', 'petButtons', \App\Nova\PetButton::class),
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
