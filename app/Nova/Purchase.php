<?php

namespace App\Nova;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        'code',
    ];

    public static $group = 'Main';

    public static $orderBy = ['code' => 'desc'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
//            ID::make(__('ID'), 'id')->hideFromDetail(),

            Text::make('Code')->exceptOnForms()->sortable(),

            BelongsTo::make('Pay From', 'account', Account::class),

            BelongsTo::make('Company')->onlyOnDetail(),

            BelongsTo::make('Vendor', 'vendor', Company::class),

            Date::make('Purchased At')->nullable(),

            Currency::make('Total')
                ->currency('IDR')->readonly()
                ->exceptOnForms(),

            Badge::make('Status', function () {
                return $this->status;
            })->map(\App\Models\Invoice::statusMap()),

            Tabs::make('Relations', [
                HasMany::make('Items', 'items', PurchaseItem::class),

                 MorphMany::make('Expenses'),

                 MorphMany::make('Withholdings')
            ]),

            new Panel('Cost Calculation', $this->costFields()),

            MorphOne::make('Invoice'),
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
        return [
        ];
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

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  Builder  $query
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $company = $request->user()->companies()->first();
        return $query->where('company_id', optional($company)->id);
    }

    protected static function applyOrderings($query, array $orderings): Builder
    {
        if (empty($orderings) && property_exists(static::class, 'orderBy')) {
            $orderings = static::$orderBy;
        }

        return parent::applyOrderings($query, $orderings);
    }
}
