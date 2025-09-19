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
            BelongsTo::make('Pet', 'pet', \App\Nova\Pet::class),
            Text::make('Loading Color', 'loading_color')->sortable(),
            Text::make('Cover Name Color', 'cover_name_color')->sortable(),
            Text::make('Header Love Color', 'header_love_color')->sortable(),
            Text::make('Header Footprint Color', 'header_footprint_color')->sortable(),
            Text::make('Day Text Color', 'day_text_color')->sortable(),
            Text::make('Title Color', 'title_color')->sortable(),
            Text::make('Handshake Button Color', 'handshake_button_color')->sortable(),
            Text::make('Videos Button Color', 'videos_button_color')->sortable(),
            Text::make('Bubble Ball Color', 'bubble_ball_color')->sortable(),
            Text::make('Bubble Background', 'bubble_background')->sortable(),
            Text::make('Footprint Color', 'footprint_color')->sortable(),
            Text::make('Footer Background Color', 'footer_background_color')->sortable(),
            Text::make('Function Color', 'function_color')->sortable(),
            Text::make('Function Background Color', 'function_background_color')->sortable(),
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
