<?php

namespace App\Nova;

use Brick\Money\Money;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Http\Requests\NovaRequest;

class TransactionItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\TransactionItem::class;

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

    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
//            ID::make(__('ID'), 'id'),

            BelongsTo::make('Transaction'),

            BelongsTo::make('Product')->required(),

            Currency::make('Price')->currency('IDR')->required()
                ->onlyOnForms(),

            Number::make('Quantity')->required()->onlyOnForms(),

            Stack::make(
                'Qty',
                [
                    Line::make('Quantity')->asHeading(),
                    Line::make(
                        'Price',
                        function () {
                            return '@' . Money::of($this->price, 'IDR');
                        }
                    )->asSmall()
                ]
            )->exceptOnForms(),

            Stack::make('Total', $this->totalFields())->exceptOnForms(),

            MorphMany::make('Withholdings')
        ];
    }

    protected function totalFields()
    {
        if ($this->sub_total > $this->total) {
            return [
                Currency::make('Total')->currency('IDR'),

                Line::make(
                    'Sub Total',
                    function () {
                        $formatted = Money::of($this->sub_total, 'IDR');
                        return "<span style='font-size: 10px;'><del>{$formatted}</del></span>";
                    }
                )->asSmall()->asHtml(),
            ];
        } else {
            return [
                Currency::make('Total')->currency('IDR')
            ];
        }
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
}
