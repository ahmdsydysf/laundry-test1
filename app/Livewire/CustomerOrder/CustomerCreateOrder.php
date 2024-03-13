<?php

namespace App\Livewire\CustomerOrder;

use App\Livewire\Forms\OrderDetailForm;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CustomerCreateOrder extends Component
{
    public function render()
    {
        return view('livewire.customer-order.customer-create-order')
            ->layout('layouts.customer')
            ->title(config('app.name') . ' | ' . 'إضافه طلب');
    }
    public OrderDetailForm $orderDetailForm;

    public $showTotalPrice = true;

    #[Computed(persist: true)]
    public function items()
    {
        return Cache::rememberForever('items_for_livewire', fn() => Item::get());
    }

    public function updated($attr, $value): void
    {
        $this->validateOnly($attr);
    }

    ############################### Start Orders ##############################

    public function updatedOrderDetailFormItemId($item_id): void
    {
        $this->orderDetailForm->updatedItemId($item_id);
    }

    public function updatedOrderDetailFormServiceId($value): void
    {
        $this->orderDetailForm->updatedServiceId($value);
    }

    public function addOrderDetail(): void
    {
//        dd('called');
        $this->validate();
        $this->orderDetailForm->addOrderDetail();
        $this->dispatch('order-added');
    }

    public function editOrderDetail($index): void
    {
        $this->orderDetailForm->editOrder($index);
        $this->dispatch('edit-order', $this->orderDetailForm->item_id);
    }

    public function updateOrderDetail($index): void
    {
        $this->orderDetailForm->editOrder($index);
    }

    public function deleteOrderDetail($index): void
    {
        $this->orderDetailForm->deleteOrder($index);
    }

    public function putOrder()
    {
        if (count($this->orderDetailForm->orders) === 0) {
            $this->addError('error_msg', 'يجب إضافة طلبات أولا');
            return;
        }


//        dd($this->orderDetailForm->ordersForTable, $this->orderDetailForm->orders);

        try {
            DB::beginTransaction();


            $order = Order::create([
                'customer_id' => auth()->id(),
                'total_price' => $this->orderDetailForm->total_cost,
                'final_total_price' => $this->orderDetailForm->final_total_cost,
            ]);

            $orderDetailToInsert = [];
            $deferredFound = false;

            foreach ($this->orderDetailForm->orders as $orderDetail) {

                $orderDetailToInsert[] = [
                    'order_id' => $order->id,
                    'item_id' => $orderDetail['item_id'],
                    'service_id' => $orderDetail['service_id'],
                    'price' => $orderDetail['price'],
                    'quantity' => $orderDetail['quantity'],
                    'total_price' => $orderDetail['total_price'],
                    'is_payment_deferred' => (bool)$orderDetail['is_payment_deferred'],
                    'description' => $orderDetail['description'],
                    'created_at' => now()
                ];

                if ($orderDetail['is_payment_deferred']){
                    $deferredFound = true;
                }
            }
            OrderDetail::insert($orderDetailToInsert);
            if ($deferredFound) {
                $order->update([
                    'has_deferred_payment' => true
                ]);
            }
            DB::commit();
        } catch (\Throwable $throwable) {
            DB::rollBack();
            $this->addError('error_msg', 'حدث خطأ اثناء حفظ الطلب');
            return;
        }

        toast('تم إضافة الطلب بنجاح', 'success');

        $this->redirectRoute('customer.profile.show');
    }
}
