<?php

namespace App\Http\Requests\setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:254', 'unique:settings,name,' . $this->setting->id],
            'value' => ['nullable'],
            'img' => ['nullable', 'image', 'mimes:jpg,webp,jpeg,png']
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'القطعة',
            'value' => 'القيمة',
            'img' => 'الصورة'
        ];
    }
}
