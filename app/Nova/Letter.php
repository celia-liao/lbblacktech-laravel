<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;

class Letter extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Letter>
     */
    public static $model = \App\Models\Letter::class;

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
    public static $title = 'letter_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'letter_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('Letter ID', 'letter_id')->sortable(),
            BelongsTo::make('Pet', 'pet', \App\Nova\Pet::class)
                ->display('pet_name'), 
            Textarea::make('Letter Content', 'letter_content')
                ->sortable()
                ->help('輸入信件內容, 若要換行顯示請輸入"&lt;br&gt;"'),
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
