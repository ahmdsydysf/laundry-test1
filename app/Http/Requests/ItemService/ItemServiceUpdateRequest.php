<?php

namespace App\Http\Requests\ItemService;

use Illuminate\Foundation\Http\FormRequest;

class ItemServiceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdministrator();
    }

    public function rules(): array
    {
        return [
            'service_id' => ['required', 'exists:services,id'],
            'item_id' => ['required', 'exists:items,id'],
            'price' => ['nullable', 'numeric'],
            'note' => ['nullable', 'string', 'max:255']
        ];
    }

    public function attributes(): array
    {
        return [
            'service_id' => 'الخدمة',
            'item_id' => 'القطعة',
            'price' => 'السعر',
            'note' => 'الملاحظه'
        ];
    }
}
