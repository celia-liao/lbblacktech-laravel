<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
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
            Text::make('Age', 'age')->sortable(),
            Text::make('Event Title', 'event_title')->sortable(),
            Text::make('Event Description', 'event_description')->sortable(),
            Image::make('Life Background', 'background')
                ->disk('public')
                ->thumbnail(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'background'))
                ->preview(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'background')),
        
            Image::make('Event Photo', 'event_photo')
                ->disk('public')
                ->thumbnail(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'photo'))
                ->preview(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'photo')),
        
            Image::make('Original Image', 'original_image')
                ->disk('public')
                ->thumbnail(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'original'))
                ->preview(fn($value, $disk, $model) => $model->getPetImageUrl($value, 'original')),
                
            Boolean::make('Is Ending', 'is_ending')->sortable(),
            Boolean::make('Is Visible', 'is_visible')->sortable(),
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
