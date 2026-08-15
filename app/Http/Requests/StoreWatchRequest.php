<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => 'required|url|max:2048',
            'css_selector' => 'nullable|string|max:255',
            'check_frequency_minutes' => 'required|integer|min:5|max:1440',
        ];
    }
}