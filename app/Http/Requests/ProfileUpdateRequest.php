<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['required', 'string', 'numeric', 'regex:/^01[0125]{1}[0-9]{8}$/', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'الأسم',
            'email' => 'البريد',
            'phone' => 'الهاتف',
            'hire_date' => 'تاريخ التعيين',
            'role' => 'الدور',
        ];
    }
}
