<?php

namespace App\Livewire\Order;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public string $search = '';

    public $orderStatus = '';
    public $paymentStatus = '';

    public function render()
    {
        $orders = Order::whereNotNull('user_id');

        // Apply filtering based on order_code or customer details
        if ($this->search) {
            $orders->where(function ($search) {
                $search->where('order_code', 'like', "%{$this->search}%")
                    ->orWhereHas('customer', function ($q) {
                        $q->where('phone', 'like', "%{$this->search}%")
                            ->orWhere('name', 'like', "%{$this->search}%")
                            ->orWhere('id', $this->search);
                    });
            });
        }

        // Apply filtering based on orderStatus
        if ($this->orderStatus) {
            $orders->where('status', $this->orderStatus);
        }

        // Apply filtering based on paymentStatus
        if ($this->paymentStatus) {
            $orders->where('payment_status', $this->paymentStatus);
        }

        // Retrieve orders with customer information, ordered by latest, and paginate
        return view('order.index', [
            'orders' => $orders->with(['customer'])->latest()->paginate(config('app.default_pagination'))
        ])->layout('layouts.app')->title(config('app.name') . ' | ' . 'الطلبات');
    }

    public function updated($attr, $value): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset();
        $this->resetPage();
    }

    public function deleteOrder($order_id): void
    {
        abort_unless(auth()->user()->isSuperAdmin(), 401);

        try {
            Order::destroy($order_id);
        } catch (\Throwable $throwable) {
            session()->flash('error-msg', 'حدث خطأ اثناء محاوله حذف الطلب.');
            return;
        }
        session()->flash('success-msg', 'تم حذف الطلب بنجاح');
    }

    public function changeStatus(Order $order, OrderStatus $orderStatus): void
    {
        try {
            $order->update([
                'status' => $orderStatus
            ]);
        } catch (\Throwable $throwable) {
            session()->flash('error-msg', 'حدث خطأ اثناء محاوله تغيير  حاله الطلب.');
        }

    }

    public function changePaymentStatus(Order $order, PaymentStatus $paymentStatus): void
    {
        try {
            if ($order->has_deferred_payment) {
                session()->flash('error-msg', 'الطلب يحتوي علي مدفوعات مؤجلة.');
                return;
            }

            $order->update([
                'payment_status' => $paymentStatus
            ]);
        } catch (\Throwable $throwable) {
            session()->flash('error-msg', 'حدث خطأ اثناء تحديث حاله الدفع.');
        }
    }
}
