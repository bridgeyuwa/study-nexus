<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\TextArea;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class LevelProgram extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\LevelProgram>
     */
    public static $model = \App\Models\LevelProgram::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','level.name','program.name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
			BelongsTo::make('program')->sortable(),
			BelongsTo::make('level'),
			Trix::make('decription'),
			Number::make('duration'),
			
			
			
			TextArea::make('Direct Entry')
            ->resolveUsing(fn () => $this->requirements->get('direct_entry'))
            ->fillUsing(fn ($request, $model, $attribute, $requestAttribute) => 
                $model->requirements->set('direct_entry', $request->get($requestAttribute))
            ),

			Textarea::make('O Level')
				->resolveUsing(fn () => $this->requirements->get('o_level'))
				->fillUsing(fn ($request, $model, $attribute, $requestAttribute) => 
					$model->requirements->set('o_level', $request->get($requestAttribute))
				),

			Textarea::make('Subjects')
				->resolveUsing(fn () => $this->requirements->get('utme_subjects'))
				->fillUsing(fn ($request, $model, $attribute, $requestAttribute) => 
					$model->requirements->set('utme_subjects', $request->get($requestAttribute))
				),
			
			
			
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
