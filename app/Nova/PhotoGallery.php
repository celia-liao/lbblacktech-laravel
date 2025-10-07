<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;

class PhotoGallery extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\PhotoGallery>
     */
    public static $model = \App\Models\PhotoGallery::class;

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
    public static $title = 'photo_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'photo_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('Photo ID', 'photo_id')->sortable(),
            BelongsTo::make('Pet', 'pet', \App\Nova\Pet::class)
                ->display('pet_name'), 
            Image::make('Photo Path', 'photo_path')
                ->disk('public')
                ->thumbnail(fn($value, $disk, $model) => $model->getPhotoGalleryImageUrl($value))
                ->preview(fn($value, $disk, $model) => $model->getPhotoGalleryImageUrl($value))
                ->help('上傳照片'),
            Select::make('Photo Category', 'photo_category')
                ->options([
                    'header' => 'Header',
                    'bubble_small' => 'Bubble Small',
                    'bubble_large' => 'Bubble Large',
                    'loading_people' => 'Loading People',
                    'loading_pet' => 'Loading Pet',
                ])
                ->sortable()
                ->help('選擇照片類別'),
            Text::make('Display Order', 'display_order')
                ->sortable()
                ->help('輸入照片顯示順序'),
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
