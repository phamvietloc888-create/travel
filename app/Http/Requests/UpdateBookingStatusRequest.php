<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'booking_status' => ['required', Rule::in(['PENDING', 'CONFIRMED', 'CANCELED', 'COMPLETED'])],
            'payment_status' => ['nullable', Rule::in(['UNPAID', 'PENDING', 'PAID', 'FAILED', 'REFUNDED'])],
        ];
    }
}
