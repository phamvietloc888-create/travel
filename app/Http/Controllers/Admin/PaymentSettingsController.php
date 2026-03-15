<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PaymentSettingsController extends Controller
{
    public function index(): View
    {
        $settings = PaymentSetting::query()->firstOrCreate(
            ['id' => 1],
            [
                'bank_name' => 'Vietcombank',
                'account_name' => 'CONG TY DU LICH ABC',
                'account_number' => '0123456789',
                'instructions' => 'Chuyển khoản đúng nội dung để hệ thống đối chiếu.',
                'is_active' => true,
            ]
        );

        return view('admin.media.index', ['settings' => $settings]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:100'],
            'instructions' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
            'qr_code' => ['nullable', 'image', 'max:4096'],
        ]);

        $settings = PaymentSetting::query()->firstOrCreate(['id' => 1]);

        if ($request->hasFile('qr_code')) {
            $newPath = $request->file('qr_code')->store('payment-settings', 'public');

            if (!empty($settings->qr_code_path)) {
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
