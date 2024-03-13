<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'regex:/^01[0125]{1}[0-9]{8}$/', 'unique:customers,phone,' . $this->customer->id,],

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
