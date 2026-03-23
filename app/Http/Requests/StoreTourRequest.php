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
        if ($this->filled('name')) {
            $this->merge([
                'name' => str_replace(['–', '—'], '-', $this->input('name')),
            ]);
        }

        if ($this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug(str_replace(['–', '—'], '-', $this->input('slug'))),
            ]);
        }

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
            'transport_type' => ['nullable', 'string', 'max:255'],
            'hotel_name' => ['nullable', 'string', 'max:255'],
            'hotel_stars' => ['nullable', 'integer', 'min:1', 'max:5'],
            'max_people' => ['required', 'integer', 'min:1'],
            'available_seats' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['DRAFT', 'PUBLISHED', 'HIDDEN'])],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'short_desc' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'images' => ['nullable', 'array', 'max:3'],
            'images.*' => ['nullable', 'image', 'max:4096'],
            'schedules.*.day_no' => ['nullable', 'integer', 'min:1'],
            'schedules.*.title' => ['nullable', 'string', 'max:255'],
            'schedules.*.detail' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.max' => 'Bạn chỉ có thể thêm tối đa 3 ảnh gallery cho mỗi tour.',
        ];
    }
}
