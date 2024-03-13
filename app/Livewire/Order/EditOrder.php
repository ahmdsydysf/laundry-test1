<?php

namespace App\Livewire\Order;

use App\Enums\PaymentType;
use App\Livewire\Forms\CustomerForm;
use App\Livewire\Forms\OrderForm;
use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemService;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditOrder extends Component
{
    public CustomerForm $customerForm;
    public OrderForm $orderForm;

    public Order $order;

    public $selectedOrder = '';

    public $total_price = 0;
    #[Validate('numeric|min:0', as: 'المبلغ المدفوع')]
    public $paid_money = 0;
    public $remaining_money = 0;
    #[Validate('required|in:1,2', as: 'نوع الدفع')]
//    #[Validate('in:1,2')]
    public $payment_type = 1;

    #[Validate('nullable', as: 'تاريخ التسليم')]
    #[Validate('date')]
    public $deliver_date;

    public function mount(Order $order)
    {
        $this->orderForm->orders = $order->orderDetails->load(['item', 'service'])->toArray();
        $this->customerForm->setValues($order->customer);
        $this->deliver_date = $order->deliver_date;

        $this->total_price = $order->total_price;
        if ($order->payment_type === PaymentType::DEFERRED) {
            $this->payment_type = $order->payment_type->value;
            $this->paid_money = $order->paid_money;
            $this->remaining_money = $order->remaining_money;
        }

        $this->orderForm->setDefaultValues();
        $this->orderForm->isEditMode = true;
    }

    public function render()
    {
        return view('order.edit')
            ->title(config('app.name') . ' | ' . 'تعديل طلب');
    }

    public function updated($attr, $value): void
    {
        $this->resetValidation('orderForm.error_msg');
        $this->validateOnly($attr);
    }

    ################### Customer ########################
    public function updatedCustomerFormSearch($value): void
    {
        $this->customerForm->getCustomers($value);
    }

    public function updatedCustomerFormId(Customer $customer): void
    {
        $this->customerForm->setId($customer);
    }

    public function cancelCustomer(): void
    {
        $this->customerForm->reset();
    }
    ################### End Customer ########################
    ################## Orders ################################

    public function updatedOrderFormServiceId(Service $service): void
    {
        $this->reset('selectedOrder');
        $this->orderForm->setItems($service);
    }

    public function updatedOrderFormItemId($item_id): void
    {
        $this->reset('selectedOrder');
        $this->orderForm->addOrder();
        $this->calculateTotalPrice();
    }

    public function selectOrder($index): void
    {
        if (array_key_exists($index, $this->orderForm->orders)) {
            if ($index == $this->selectedOrder) {
                $this->reset('selectedOrder');
            } else {
                $this->selectedOrder = $index;
            }
        }
    }

    public function deleteOrder(): void
    {
        if (array_key_exists($this->selectedOrder, $this->orderForm->orders)) {

            $orderToBeDeleted = $this->orderForm->orders[$this->selectedOrder];

            if (isset($orderToBeDeleted['id'])) {
                try {
                    OrderDetail::destroy($orderToBeDeleted['id']);
                    array_splice($this->orderForm->orders, $this->selectedOrder, 1);
                } catch (\Throwable $throwable) {
                    $this->addError('error_msg', 'حدث خطأ اثناء الحذف');
                }
            } else {
                array_splice($this->orderForm->orders, $this->selectedOrder, 1);
            }
            $this->reset('selectedOrder');
            $this->calculateTotalPrice();
        }
    }

    public function applyChanges(): void
    {
        $this->orderForm->orders = array_map(function ($order) {
            $order['total_price'] = intval($order['price']) * intval($order['quantity']);
            return $order;
        }, $this->orderForm->orders);

        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice(): void
    {
        $this->total_price = collect($this->orderForm->orders)->sum('total_price');
        $this->remaining_money = $this->total_price - intval($this->paid_money);
    }

    public function updatedPaidMoney(): void
    {
        $this->remaining_money = $this->total_price - intval($this->paid_money);
    }


    public function saveOrder(): void
    {
        $this->validate();
        if (count($this->orderForm->orders) === 0) {
            $this->addError('error_msg', 'يجب إضافة طلبات أولا');
            return;
        }

        try {
            DB::transaction(function () {
                $ordersToBeUpdatedOrInserted = [];
                $deferredFound = false;

                // Check if there is no customer
                if (!$this->customerForm->id) {
                    $this->customerForm->create();
                }

                // Prepare the data
                foreach ($this->orderForm->orders as $orderDetail) {

                    $ordersToBeUpdatedOrInserted[] = [
                        'id' => $orderDetail['id'],
                        'order_id' => $this->order->id,
                        'item_id' => $orderDetail['item_id'],
                        'service_id' => $orderDetail['service_id'],
                        'price' => $orderDetail['price'],
                        'quantity' => $orderDetail['quantity'],
                        'total_price' => $orderDetail['total_price'],
                        'is_payment_deferred' => !$orderDetail['price'],
                        'description' => $orderDetail['description'],
                    ];

                    if (!$orderDetail['price']) {
                        $deferredFound = true;
                    }
                }

                // Fill Order Object to check if it changed or not
                $this->order->fill([
                    'total_price' => $this->total_price,
                    'paid_money' => $this->payment_type == 1 ? 0 : intval($this->paid_money),
                    'remaining_money' => $this->payment_type == 1 ? 0 : intval($this->remaining_money),
                    'payment_type' => $this->payment_type,
                    'customer_id' => $this->customerForm->id,
                    'deliver_date' => $this->deliver_date,
                    'has_deferred_payment' => $deferredFound
                ]);

                if ($this->order->isDirty()) {
                    $this->order->save();
                }

                // update or insert the orderDetails using id,item_id,service_id
                OrderDetail::upsert($ordersToBeUpdatedOrInserted,
                    ['id', 'item_id', 'service_id']
                );

            });
        } catch (\Throwable $throwable) {
            $this->addError('error_msg', 'حدث خطأ اثناء حفظ الطلب');
            return;
        }

        toast('تم تعديل الطلب بنجاح', 'success');
        $this->redirectRoute('orders.show', $this->order->id);
    }
}
