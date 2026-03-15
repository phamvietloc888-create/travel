<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class contactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('clients.contact');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:3000'],
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'subject.required' => 'Vui lòng nhập chủ đề.',
            'message.required' => 'Vui lòng nhập nội dung liên hệ.',
        ]);

        Log::info('Client contact submission', $data);

        return back()->with('success', 'Đã gửi liên hệ thành công. Chúng tôi sẽ phản hồi sớm nhất.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
