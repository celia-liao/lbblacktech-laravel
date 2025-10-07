<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class TimelineEvent extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TimelineEvent>
     */
    public static $model = \App\Models\TimelineEvent::class;

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
    public static $title = 'event_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'event_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('Event ID', 'event_id')->sortable(),
            BelongsTo::make('Pet', 'pet', \App\Nova\Pet::class)
                ->display('pet_name'), 
            Text::make('Age', 'age')
                ->sortable()
                ->help('輸入事件發生時的年齡'),
            Text::make('Event Title', 'event_title')
                ->sortable()
                ->help('輸入事件標題'),
            Text::make('Event Description', 'event_description')
                ->sortable()
                ->help('輸入事件詳細描述'),
            Image::make('Life Background', 'background')
                ->disk('public')
                ->thumbnail(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'background'))
                ->preview(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'background'))
                ->help('文字背景圖'),
            Image::make('Event Photo', 'event_photo')
                ->disk('public')
                ->thumbnail(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'photo'))
                ->preview(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'photo'))
                ->help('毛孩圖'),
            Image::make('Original Image', 'original_image')
                ->disk('public')
                ->thumbnail(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'original'))
                ->preview(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'original'))
                ->help('毛孩原圖'),
            Boolean::make('Is Ending', 'is_ending')
                ->sortable()
                ->help('勾選是否為結尾事件'),
            Boolean::make('Is Visible', 'is_visible')
                ->sortable()
                ->help('勾選是否顯示'),
            Text::make('Display Order', 'display_order')->sortable(),
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
