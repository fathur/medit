<?php

namespace App\Nova;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
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

class Transaction extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Transaction::class;

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
        'code',
    ];

    public static $group = 'Main';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
//            ID::make(__('ID'), 'id')->hideFromDetail(),

            Text::make('Code')->exceptOnForms()
                ->sortable(),

            BelongsTo::make('Pay To', 'account', Account::class),

            BelongsTo::make('Company')->onlyOnDetail(),

            BelongsTo::make('Customer')->showCreateRelationButton(),

            Date::make('Transaction At')->nullable(),




            Currency::make('Total')
                ->currency('IDR')->readonly()
                ->exceptOnForms(),

            Badge::make('Status', function () {
                return $this->status;
            })->map(\App\Models\Invoice::statusMap()),



            Tabs::make('Relations', [
                HasMany::make('Items', 'items', TransactionItem::class),

                MorphMany::make('Expenses'),

                MorphMany::make('Withholdings'),
            ]),

            new Panel('Cost Calculation', $this->costFields()),

            MorphOne::make('Invoice'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
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

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $company = $request->user()->companies()->first();
        return $query->where('company_id', optional($company)->id);
    }
}
