<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Salary;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
//    /**
//     * Show Statistics
//     *
//     * @param Request $request
//     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
//     */
    public function __invoke(Request $request)
    {
        $data = [];
        if (auth()->user()->isSuperAdmin()) {
            // Orders
            $yearly_orders = Order::whereYear('created_at', now()->year)->get(['id', 'status', 'payment_status', 'total_price', 'created_at']);
            $monthly_orders = $yearly_orders->filter(fn(Order $order) => $order->created_at->month === now()->month);
            $week_orders = $monthly_orders->filter(fn($order) => $order->created_at->week === now()->week);
            $daily_orders = $week_orders->filter(fn($order) => $order->created_at->day === now()->day);

            // day
            $daily_orders_count = $daily_orders->count();
            $daily_paid_sum = $daily_orders->where('payment_status', PaymentStatus::PAID)->sum('total_price');
            $daily_pending_count = $daily_orders->where('status', OrderStatus::PENDING)->count();
            $daily_completed_count = $daily_orders->where('status', OrderStatus::COMPLETED)->count();

            // week
            $weekly_orders_count = $week_orders->count();
            $weekly_paid_sum = $week_orders->where('payment_status', PaymentStatus::PAID)->sum('total_price');

            // month
            $monthly_orders_count = $monthly_orders->count();
            $monthly_paid_sum = $monthly_orders->where('payment_status', PaymentStatus::PAID)->sum('total_price');

            // Year
            $yearly_paid_sum = $monthly_orders->where('payment_status', PaymentStatus::PAID)->sum('total_price');

            // New Monthly Customers
            $new_monthly_customer = Customer::whereMonth('created_at', now()->month)->get(['created_at']);
            $new_monthly_customer_count = $new_monthly_customer->count();
            $new_weekly_customer_count = $new_monthly_customer->filter(fn(Customer $customer) => $customer->created_at->week === now()->week)->count();
            $new_daily_customer_count = $new_monthly_customer->filter(fn(Customer $customer) => $customer->created_at->day === now()->day)->count();

            // Expenses
            $yearly_expenses = Expense::whereYear('created_at', now()->year)->get(['value', 'created_at']);
            $monthly_expenses = $yearly_expenses->filter(fn(Expense $expense) => $expense->created_at->month === now()->month);
            $weekly_expenses = $monthly_expenses->filter(fn(Expense $expense) => $expense->created_at->week === now()->week);

            $total_yearly_expenses = $yearly_expenses->sum('value');
            $total_monthly_expenses = $monthly_expenses->sum('value');
            $total_weekly_expenses = $weekly_expenses->sum('value');

            // Profit
            $yearly_profit = $yearly_paid_sum - $total_yearly_expenses;
            $monthly_profit = $monthly_paid_sum - $total_monthly_expenses;
            $weekly_profit = $weekly_paid_sum - $total_weekly_expenses;

            // After day 25th of the month the salaries will be counted
            if (date('j') > 25) {
                $salaries_sum = Salary::sum('value');

                $monthly_profit -= $salaries_sum;

                $yearly_profit -= $salaries_sum * intval(date('n'));
            }

            // Services Ordered today
            $serviceCounts = [];
            $daily_orders->load(
                [
                    'orderDetails' => ['service']
                ]
            )->flatMap(function ($order) use (&$serviceCounts) {
                return $order->orderDetails->map(function (OrderDetail $orderDetail) use (&$serviceCounts) {
                    $serviceName = $orderDetail->service->name;

                    // Increment the count for this service
                    $serviceCounts[$serviceName] = ($serviceCounts[$serviceName] ?? 0) + 1;
                }) ?? [];
            });

            // Sort the results
            arsort($serviceCounts);

            // Chart to display the services
            $services_chart = app()->chartjs
                ->name('pieChartTest')
                ->type('pie')
                ->size(['width' => 500, 'height' => 500])
                ->labels(array_keys($serviceCounts))
                ->datasets([
                    [
                        'backgroundColor' => $this->generateRandomColor(count($serviceCounts)),
                        'data' => array_values($serviceCounts)
                    ]
                ]);


            $data = [
                #################### Daily Orders #########################
                'daily_orders_count' => $daily_orders_count,
                'daily_paid_sum' => $daily_paid_sum,
                'daily_pending_count' => $daily_pending_count,
                'daily_completed_count' => $daily_completed_count,
                ###########################################################

                ################### Weekly Orders #########################
                'weekly_orders_count' => $weekly_orders_count,
                'weekly_paid_sum' => $weekly_paid_sum,
                ###########################################################

                ################### Monthly Orders ########################
                'monthly_orders_count' => $monthly_orders_count,
                'monthly_paid_sum' => $monthly_paid_sum,
                ###########################################################

                ###################### Services ######################
                'daily_services_count' => $serviceCounts,
                ################ Services Chart ##################
                'services_chart' => $services_chart,
                ##################################################

                ###################### Customers ###########################
                'new_monthly_customer_count' => $new_monthly_customer_count,
                'new_weekly_customer_count' => $new_weekly_customer_count,
                'new_daily_customer_count' => $new_daily_customer_count,
                ###########################################################

                ###################### Profit #############################
                'weekly_profit' => $weekly_profit,
                'monthly_profit' => $monthly_profit,
                'yearly_profit' => $yearly_profit,
                ###########################################################
            ];
        }


        return view('overview', $data);
    }

    /**
     * Generate Background Color for the chart
     *
     * @param $count
     * @return array
     */
    private function generateRandomColor($count)
    {
        $colors = [];

        for ($i = 0; $i < $count; $i++) {
            $colors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }

        return $colors;
    }
}
