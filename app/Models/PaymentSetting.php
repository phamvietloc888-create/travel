<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_name',
        'account_number',
        'qr_code_path',
        'instructions',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getQrCodeUrlAttribute(): ?string
    {
        if (empty($this->qr_code_path)) {
            return null;
        }

        return route('payment.qr');
    }
}
