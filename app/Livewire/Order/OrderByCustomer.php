<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderByCustomer extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $orders = Order::whereNull('user_id');

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

        return view('order.order-by-customer',
            [
                'orders' => $orders->with(['customer'])->latest()->paginate(config('app.default_pagination'))
            ]
        )->layout('layouts.app')
            ->title(config('app.name') . ' | ' . 'طلبات العملاء');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function addToOrders(Order $order): void
    {
        abort_if($order->user_id, 401);

        try {
            $order->update(['user_id' => auth()->id()]);
        } catch (\Throwable $throwable) {
            session()->flash('error-msg', 'حدث خطأ إضافه الطلب.');
            return;
        }
        session()->flash('success-msg', 'تم إضافه الطلب بنجاح');
    }

    public function deleteOrder(Order $order): void
    {
        abort_if($order->user_id, 401);

        try {
            $order->delete();
        } catch (\Throwable $throwable) {
            session()->flash('error-msg', 'حدث خطأ اثناء محاوله حذف الطلب.');
            return;
        }
        session()->flash('success-msg', 'تم حذف الطلب بنجاح');
    }
}
