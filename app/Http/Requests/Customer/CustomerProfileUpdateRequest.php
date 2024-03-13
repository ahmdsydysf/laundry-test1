<?php

namespace App\Http\Requests\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'regex:/^01[0125]{1}[0-9]{8}$/', Rule::unique(Customer::class)->ignore($this->user()->id)]
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الأسم',
            'address' => 'العنوان',
            'phone' => 'الهاتف',
        ];
    }
}
