<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;

class LifeSlide extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\LifeSlide>
     */
    public static $model = \App\Models\LifeSlide::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'life_slide_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'life_slide_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('Life Slide ID', 'life_slide_id')->sortable(),
            BelongsTo::make('Pet', 'pet', \App\Nova\Pet::class),
            Image::make('Life Slide Image', 'life_slide_image')
                ->disk('public')
                ->thumbnail(fn($value, $disk, $model) => $model->getLifeSlideUrl($value, 'image'))
                ->preview(fn($value, $disk, $model) => $model->getLifeSlideUrl($value, 'image')),
            File::make('Life Slide Video Upload', 'life_slide_video')
            ->disk('public')
            ->help('上傳 mp4 影片'),
        
            Text::make('Preview Video', function () {
                if (!$this->life_slide_video) {
                    return "<span style='color:red;'>❌ 尚未上傳影片</span>";
                }
            
                $url = $this->getLifeSlideUrl($this->life_slide_video, 'video');
            
                return "<video width='320' controls style='border-radius:8px'>
                            <source src='{$url}' type='video/mp4'>
                            Your browser does not support the video tag.
                        </video>";
            })->asHtml()->onlyOnDetail(),
                 
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
