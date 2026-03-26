<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:50', 'unique:promotions,code'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['PERCENT', 'FIXED'])],
            'value' => ['required', 'numeric', 'min:0'],
            'min_total' => ['nullable', 'numeric', 'min:0'],
            'max_discount' => ['nullable', 'numeric', 'min:0'],
            'total_limit' => ['nullable', 'integer', 'min:0'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'status' => ['required', Rule::in(['ACTIVE', 'INACTIVE'])],
        ];
    }
}
