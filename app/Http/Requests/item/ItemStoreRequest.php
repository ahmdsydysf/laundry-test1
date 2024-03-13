<?php

namespace App\Http\Requests\item;

use App\Enums\Roles;
use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Check if the authenticated user is an admin
        return auth()->user()->isAdministrator();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:items,name'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الصنف',
        ];
    }
}
