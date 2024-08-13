<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Panel;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;

use Laravel\Nova\Http\Requests\NovaRequest;

class Institution extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Institution>
     */
    public static $model = \App\Models\Institution::class;

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
			Text::make('Former Name')->sortable(),
			Text::make('Abbr')->sortable(),
			Text::make('Slogan'),
			Select::make('Established')->options($this->yearRange())->sortable(),
			BelongsTo::make('Institution Head'),
			Text::make('Head'),
			Trix::make('Description'),
			BelongsTo::make('Parent Institution','parentInstitution','App\Nova\Institution')->nullable(),
			BelongsTo::make('Institution Type')->sortable(),
			BelongsTo::make('Category')->sortable(),
			BelongsTo::make('Term')->sortable(),
			BelongsTo::make('Accreditation Body')->sortable(),
			BelongsTo::make('Accreditation Status')->sortable()->nullable(),
			BelongsTo::make('Religious Affiliation')->sortable(),
			BelongsTo::make('State')->sortable(),
			Text::make('locality'),
			Text::make('Address'),
			Number::make('Postal Code'),
			URL::make('Url'),
			Email::make('Email'),
			URL::make('Logo'),
			Number::make('Rank')->sortable(),
			Text::make('Coordinates'),
			 
			HasMany::make('Phone Numbers'),
			 
			 
			//BelongsToMany::make('InstitutionProgram'),
			HasMany::make('Child Institutions','childInstitutions','App\Nova\Institution'),
		
			BelongsToMany::make('Programs'),
			
			
			
        ];
    }
	
	
	
	private function yearRange()
	{
		$years = range(1932, date('Y'));	
		
		return array_combine($years, $years);
		
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
