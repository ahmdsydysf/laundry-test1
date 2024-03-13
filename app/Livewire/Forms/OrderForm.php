<?php

namespace App\Livewire\Forms;

use App\Models\ItemService;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class OrderForm extends Form
{
    #[Validate(['nullable', 'integer'])]
    public $item_id = '';

    #[Validate(['nullable', 'integer'])]
    public $service_id = '';

    #[Validate(['nullable', 'integer'])]
    public $price = '';

    #[Validate(['required', 'integer'])]
    public $quantity = 1;

    ############ props ###############

    #[Computed(persist: true)]
    public function services()
    {
        return Cache::rememberForever('Services-livewire', fn() => Service::get());
    }

    public $items = [];

    public $orders = [];
    public bool $isEditMode = false;

    ############ props ###############

    public function setItems(Service $service): void
    {
        $this->reset('items', 'item_id', 'quantity');
        $this->items = $service->items;
    }

    public function addOrder(): void
    {
        foreach ($this->orders as $orderDetail) {
            if ($orderDetail['item_id'] == $this->item_id && $orderDetail['service_id'] == $this->service_id && $orderDetail['quantity'] == $this->quantity) {
                $this->addError('error_msg', 'الطلب موجود بالفعل. لايمكن تكرار الطلب');
                return;
            }
        }

        /**
         * @var ?ItemService $itemService
         */
        $itemService = ItemService::with(['service', 'item'])->firstWhere(['service_id' => $this->service_id, 'item_id' => $this->item_id]);
        if ($itemService)
            $this->orders[] = [
                'id' => null,
                'item' => $itemService->item,
                'item_id' => $itemService->item_id,
                'service' => $itemService->service,
                'service_id' => $itemService->service_id,
                'quantity' => $this->quantity,
                'price' => $itemService->price,
                'note' => $itemService->note,
                'total_price' => $itemService->price * $this->quantity,
                'description' => ''
            ];

        $this->reset('item_id');
    }

    public function setDefaultValues(): void
    {
        $service = $this->services()->first();
        $this->service_id = $service->id;
        $this->items = $service->items;
    }
}
