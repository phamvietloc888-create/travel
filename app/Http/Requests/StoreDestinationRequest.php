<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreDestinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->name) {
            $this->merge(['slug' => Str::slug($this->name)]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('destinations', 'slug')],
            'description' => ['nullable', 'string'],
            'province' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['DRAFT', 'PUBLISHED', 'HIDDEN'])],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
