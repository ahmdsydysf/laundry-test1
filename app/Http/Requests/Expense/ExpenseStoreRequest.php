<?php

namespace App\Http\Requests\Expense;

use App\Enums\ExpensesType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(ExpensesType::cases())],
            'user_id' => ['exists:users,id'],
            'value' => ['required', 'nullable'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الاسم',
            'type' => 'النوع',
            'user_id' => 'الموظف',
            'value' => 'القيمه',
            'description' => 'الوصف',
        ];
    }
}
