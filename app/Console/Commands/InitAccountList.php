<?php

namespace App\Console\Commands;

use App\Models\Account;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class InitAccountList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init list of accounts into database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd($this->findCategoryNameBySlug('cash-bank'));
//        foreach ($this->accounts() as $account) {
//            Account::create([
//                'code' => $account['code'],
//                'name' => $account['name'],
//                'category' => $account['category']
//            ]);
//        }
    }

    /**
     * @return Collection
     */
    protected function categories(): Collection
    {
        return collect([
            [
                'slug'  => 'cash-bank',
                'name'  => 'Cash & Bank'
            ],
            [
                'slug'  => 'ar',
                'name' => 'Account Receivable (A/R)'
            ],
            [
                'slug'  => 'inventory',
                'name'  => 'Inventory'
            ],
            [
                'slug' => 'assets-current-other',
                'name'  => 'Other Current Assets'
            ],
            [
                'slug' => 'assets-fixed',
                'name'  => 'Fixed Assets'
            ],
            [
                'slug' => 'depreciation-amortization',
                'name'  => 'Depreciation & Amortization'
            ],
            [
                'slug' => 'assets-other',
                'name'  => 'Other Assets'
            ],
            [
                'slug' => 'ap',
                'name'  => 'Account Payable (A/P)'
            ],
            [
                'slug' => 'liabilities-current-other',
                'name'  => 'Other Current Liabilities'
            ],
            [
                'slug' => 'liabilities-long-term',
                'name'  => 'Long Term Liabilities'
            ],
            [
                'slug' => 'equity',
                'name'  => 'Equity'
            ],
            [
                'slug' => 'income',
                'name'  => 'Income'
            ],
            [
                'slug' => 'cost-of-sales',
                'name'  => 'Cost of Sales'
            ],
            [
                'slug' => 'expense',
                'name'  => 'Expenses'
            ],
            [
                'slug' => 'income-other',
                'name'  => 'Other Income'
            ],
            [
                'slug' => 'expense',
                'name'  => 'Other Expense'
            ]
        ]);
    }

    protected function accounts(): Collection
    {
        return collect([
            'code' => '1-10001',
            'name' => 'Cash',
            'category' => $this->findCategoryNameBySlug('cash-bank')
        ],[
            'code' => '1-10002',
            'name' => 'Bank Account',
            'category' => $this->findCategoryNameBySlug('cash-bank')
        ],[
            'code' => '1-10003',
            'name' => 'Giro',
            'category' => $this->findCategoryNameBySlug('cash-bank')
        ],[
            'code' => '1-10100',
            'name' => 'Account Receivable',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '1-10102',
            'name' => 'Doubtful Receivable',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('ar')
        ],[
            'code' => '',
            'name' => '',
            'category' => $this->findCategoryNameBySlug('')
        ]);
    }

    protected function findCategoryNameBySlug($slug)
    {
        return $this->categories()->firstWhere('slug', $slug)['name'];
    }
}
