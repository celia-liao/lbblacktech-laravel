<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class PetVideo extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\PetVideo>
     */
    public static $model = \App\Models\PetVideo::class;

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
    public static $title = 'video_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'video_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make('Video ID', 'video_id')->sortable(),
            BelongsTo::make('Pet', 'pet', \App\Nova\Pet::class)
                ->display('pet_name'), 
            File::make('Video Path', 'video_path')
                ->rules('mimes:mp4')
                ->help('上傳影片 (檔案格式必須為mp4)')
                ->onlyOnForms(), // 僅在表單中顯示

            Text::make('Preview Video', function () {
                if (!$this->video_path) {
                    return "<span style='color:red;'>❌ 尚未上傳影片</span>";
                }
            
                $url = $this->getPetVideoUrl($this->video_path, 'video');
            
                return "<video width='320' controls style='border-radius:8px'>
                            <source src='{$url}' type='video/mp4'>
                            Your browser does not support the video tag.
                        </video>";
            })->asHtml()->onlyOnDetail(),

            Text::make('video_path', 'video_path')
                ->onlyOnIndex(),

            Text::make('Category', 'category')
                ->sortable()
                ->help('輸入影片類別：封面(header)、泡泡(bubble)'),
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
