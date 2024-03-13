<?php

namespace App\Http\Requests\User;

use App\Enums\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return  auth()->user()->role->value < $this->user->role->value && $this?->role != Roles::SUPER_ADMIN->value;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'regex:/^01[0125]{1}[0-9]{8}$/', 'unique:users,phone,' . $this->user->id],
            'role' => ['required', Rule::in(Roles::cases())],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الأسم',
            'phone' => 'الهاتف',
            'hire_date' => 'تاريخ التعيين',
            'role' => 'الدور',
        ];
    }
}
