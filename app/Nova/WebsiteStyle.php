<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;

class WebsiteStyle extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\WebsiteStyle>
     */
    public static $model = \App\Models\WebsiteStyle::class;

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
    public static $title = 'style_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'style_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('Style ID', 'style_id')->sortable(),
            BelongsTo::make('Pet', 'pet', \App\Nova\Pet::class)
                ->display('pet_name'), 
            Text::make('Loading Color', 'loading_color')
                ->sortable()
                ->help('loading背景顏色'),
            Text::make('Cover Name Color', 'cover_name_color')
                ->sortable()
                ->help('封面名稱的圈圈 / 一起度過的日子(數字) / 生命軌跡時間軸顏色'),
            Text::make('Header Love Color', 'header_love_color')
                ->sortable()
                ->help('封面愛心顏色'),
            Text::make('Header Footprint Color', 'header_footprint_color')
                ->sortable()
                ->help('封面名稱的圈圈內腳印顏色'),
            Text::make('Day Text Color', 'day_text_color')
                ->sortable()
                ->help('生命軌跡文字 / 年紀顏色'),
            Text::make('Title Color', 'title_color')
                ->sortable()
                ->help('logo標題 / 標題 / footer文字顏色'),
            Text::make('Handshake Button Color', 'handshake_button_color')
                ->sortable()
                ->help('握手互動按鈕顏色'),
            Text::make('Videos Button Color', 'videos_button_color')
                ->sortable()
                ->help('其他互動按鈕顏色'),
            Text::make('Bubble Ball Color', 'bubble_ball_color')
                ->sortable()
                ->help('泡泡顏色'),
            Text::make('Bubble Background', 'bubble_background')
                ->sortable()
                ->help('泡泡背景漸層'),
            Text::make('Footprint Color', 'footprint_color')
                ->sortable()
                ->help('腳印顏色'),
            Text::make('Footer Background Color', 'footer_background_color')
                ->sortable()
                ->help('頁尾背景顏色'),
            Text::make('Function Color', 'function_color')
                ->sortable()
                ->help('狀態列顏色'),
            Text::make('Function Background Color', 'function_background_color')
                ->sortable()
                ->help('狀態列背景顏色'),
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
