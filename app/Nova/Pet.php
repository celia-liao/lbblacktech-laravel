<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasOne;

class Pet extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Pet>
     */
    public static $model = \App\Models\Pet::class;

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
            Text::make('Pet Name', 'pet_name')->sortable(),
            Text::make('Website Slug', 'website_slug')->sortable(),
            Text::make('Slogan', 'slogan')->sortable(),
            Boolean::make('Is Active', 'is_active')->sortable(),

            // ⭐ 掛載 Letter
            HasOne::make('Letter', 'letter', \App\Nova\Letter::class),

            // ⭐ 掛載 Website Setting
            HasOne::make('Website Setting', 'websiteSetting', \App\Nova\WebsiteSetting::class),
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
