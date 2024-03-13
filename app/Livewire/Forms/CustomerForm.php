<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CustomerForm extends Form
{

    public ?int $id = null;

    #[Validate('required', as: 'الأسم')]
    #[Validate('string')]
    public $name;

    #[Validate('required', as: 'الهاتف')]
    #[Validate('regex:/^01[0125]{1}[0-9]{8}$/', as: 'الهاتف')]
    public $phone;

    #[Validate('required', as: 'العنوان')]
    #[Validate('string')]
    public $address;

    public string $search = '';
    public $customers = [];


    public function setValues(Customer $customer): void
    {
        $this->id = $customer->id;
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
    }

    public function create()
    {
        $this->id = Customer::create($this->only('name', 'phone', 'address'))->id;
    }

    public function setId(Customer $customer): void
    {
        $this->setValues($customer);
        $this->reset('search', 'customers');
    }

    public function getCustomers($value): void
    {
        if ($value)
            $this->customers = Customer::where('id', $value)
                ->orWhere('phone', 'LIKE', "{$value}%")
                ->orWhere('name', 'LIKE', "%{$value}%")
                ->orWhere('id', '=', $value)
                ->get();
        else
            $this->customers = [];
    }

    public function resetForNextOrder()
    {
        $this->reset('id', 'name', 'phone', 'address');
    }
}
