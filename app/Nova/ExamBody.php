<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;

use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Storage;

class ExamBody extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ExamBody>
     */
    public static $model = \App\Models\ExamBody::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name',
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
            Text::make('ID')->sortable(),
			Text::make('Name')->sortable(),
			Text::make('Abbr')->sortable(),
			Trix::make('Description')->nullable(),
			BelongsTo::make('State')->sortable(),
			Text::make('Address')->sortable(),
			Text::make('Locality')->nullable(),
			Number::make('Postal Code')->sortable(),
			URL::make('Url'),
			Image::make('Logo')	
					->disk('public')
					->disableDownload()
					->prunable()
					->nullable()
					->thumbnail(function () {
					return $this->logo ? Storage::url($this->logo) : null;
					})
					->preview(function () {
						return $this->logo ? Storage::url($this->logo) : null;
					})
					->path('images/exam_bodies')
					->storeAs(function (Request $request){
						return $request->abbr .'-logo.'. $request->file('logo')->extension();
					}),
			
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
