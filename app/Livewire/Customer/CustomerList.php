<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerList extends Component
{
    use WithPagination;
    public $search;

    public function render()
    {
        $customers = Customer::where('name', 'like', "%$this->search%")
            ->orWhere('id', 'like', "%$this->search%")
            ->orWhere('phone', 'like', "%$this->search%")
            ->paginate(config('app.default_pagination'));
        return view('customer.index', [
            'customers' => $customers,
        ])->layout('layouts.app')->title(config('app.name') . ' | ' . 'العملاء');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
