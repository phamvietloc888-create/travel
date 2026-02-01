<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreTourRequest extends FormRequest
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
            'destination_id' => ['required', 'exists:destinations,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('tours', 'slug')],
            'price_adult' => ['required', 'numeric', 'min:0'],
            'price_child' => ['nullable', 'numeric', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'start_location' => ['nullable', 'string', 'max:255'],
            'max_people' => ['required', 'integer', 'min:1'],
            'available_seats' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['DRAFT', 'PUBLISHED', 'HIDDEN'])],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'short_desc' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'images.*' => ['nullable', 'image', 'max:4096'],
            'schedules.*.day_no' => ['nullable', 'integer', 'min:1'],
            'schedules.*.title' => ['nullable', 'string', 'max:255'],
            'schedules.*.detail' => ['nullable', 'string'],
        ];
    }
}
