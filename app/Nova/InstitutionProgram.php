<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\TextArea;


use Laravel\Nova\Http\Requests\NovaRequest;

class InstitutionProgram extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\InstitutionProgram>
     */
    public static $model = \App\Models\InstitutionProgram::class;

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
        'id',
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
		//fix whole model
		
            ID::make()->sortable(),
			BelongsTo::make('Institution')->sortable()->searchable(),
			BelongsTo::make('Program')->sortable()->searchable(),
			BelongsTo::make('Level','level')->sortable(),
			Trix::make('Description')->nullable(),
			BelongsTo::make('ProgramMode')->sortable(),
			Number::make('Duration')->sortable(),
			Number::make('Tuition Fee')->sortable(),
			Number::make('UTME Cutoff')->sortable(),
			BelongsTo::make('AccreditationBody')->sortable(),
			BelongsTo::make('AccreditationStatus')->sortable()->nullable(),
			Boolean::make('Is Distinguished')->sortable(),
			Date::make('Accreditation Grant date')->sortable(),
			Date::make('Accreditation Expiry Date')->sortable(),
			
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
