<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PaymentSettingsController extends Controller
{
    public function index(): View
    {
        if (! Schema::hasTable('payment_settings')) {
            $settings = new PaymentSetting([
                'bank_name' => 'Vietcombank',
                'account_name' => 'CONG TY DU LICH ABC',
                'account_number' => '0123456789',
                'instructions' => 'Chuyển khoản đúng nội dung để hệ thống đối chiếu.',
                'is_active' => true,
            ]);

            return view('admin.media.index', [
                'settings' => $settings,
                'settingsTableReady' => false,
            ]);
        }

        $settings = PaymentSetting::query()->first();

        if (! $settings) {
            $settings = PaymentSetting::query()->create([
                'bank_name' => 'Vietcombank',
                'account_name' => 'CONG TY DU LICH ABC',
                'account_number' => '0123456789',
                'instructions' => 'Chuyển khoản đúng nội dung để hệ thống đối chiếu.',
                'is_active' => true,
            ]);
        }

        return view('admin.media.index', [
            'settings' => $settings,
            'settingsTableReady' => true,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        if (! Schema::hasTable('payment_settings')) {
            return back()->withErrors([
                'payment_settings' => 'Bảng payment_settings chưa được tạo. Hãy chạy migrate trước khi lưu cấu hình thanh toán.',
            ]);
        }

        $data = $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:100'],
            'instructions' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
            'qr_code' => ['nullable', 'image', 'max:4096'],
        ]);

        $settings = PaymentSetting::query()->first();

        if (! $settings) {
            $settings = PaymentSetting::query()->create();
        }

        if ($request->hasFile('qr_code')) {
            $newPath = $request->file('qr_code')->store('payment-settings', 'public');

            if (! empty($settings->qr_code_path)) {
                Storage::disk('public')->delete($settings->qr_code_path);
            }

            $data['qr_code_path'] = $newPath;
        }

        $data['is_active'] = $request->boolean('is_active');
        $settings->update($data);

        return redirect()
            ->route('admin.media.index')
            ->with('toast', 'Đã cập nhật thông tin thanh toán.');
    }
}
