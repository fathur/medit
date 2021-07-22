<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Purchase extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Purchase::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

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
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->hideFromDetail(),

            Text::make('Code')->exceptOnForms(),

            BelongsTo::make('Pay From', 'account', Account::class),

            BelongsTo::make('Company'),

            BelongsTo::make('Vendor', 'vendor', Company::class),

            Date::make('Purchased At')->nullable(),

            MorphOne::make('Invoice'),

            new Panel('Cost Calculation', $this->costFields()),

            HasMany::make('Items', 'items', PurchaseItem::class),

            Currency::make('Total')
                ->currency('IDR')->readonly()
                ->exceptOnForms(),

            MorphMany::make('Withholdings')

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    private function costFields()
    {
        return [
            Currency::make('Sub Total', 'sub_total')
                ->currency('IDR')
                ->readonly()
                ->onlyOnDetail(),

            Currency::make('Total')
                ->currency('IDR')
                ->readonly()
                ->onlyOnDetail(),


        ];
    }
}
