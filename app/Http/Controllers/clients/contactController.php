<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $thread = null;
        $messages = collect();

        if ($user = $request->user()) {
            $thread = ChatThread::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'status' => 'OPEN',
                    'last_message_at' => now(),
                ]
            );

            $thread->load(['messages.sender']);
            $messages = $thread->messages->sortBy('created_at')->values();
        }

        return view('clients.contact', compact('thread', 'messages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()
                ->route('login')
                ->with('toast', 'Vui lòng đăng nhập để nhắn tin với hỗ trợ.');
        }

        $data = $request->validate([
            'message' => ['required', 'string', 'max:3000'],
        ], [
            'message.required' => 'Vui lòng nhập nội dung cần hỗ trợ.',
        ]);

        $thread = ChatThread::firstOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'OPEN',
                'last_message_at' => now(),
            ]
        );

        ChatMessage::create([
            'thread_id' => $thread->id,
            'sender_type' => 'USER',
            'sender_user_id' => $user->id,
            'message' => $data['message'],
        ]);

        $thread->update([
            'status' => 'OPEN',
            'last_message_at' => now(),
        ]);

        return back()->with('success', 'Đã gửi tin nhắn. Chúng tôi sẽ phản hồi sớm nhất.');
    }
}
