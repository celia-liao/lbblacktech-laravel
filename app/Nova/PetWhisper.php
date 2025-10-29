<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class PetWhisper extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\PetWhisper>
     */
    public static $model = \App\Models\PetWhisper::class;

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
    public static $title = 'content';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'content'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('小語ID', 'whisper_id')->sortable(),

            BelongsTo::make('寵物', 'pet', Pet::class)
                ->searchable()
                ->sortable()
                ->nullable()
                ->help('留空則為預設小語，所有寵物都可使用'),

            Text::make('小語內容', 'content')
                ->displayUsing(function ($value) {
                    // 在列表頁面顯示時，如果內容太長則截斷
                    return strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
                })
                ->sortable()
                ->asHtml(),
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
