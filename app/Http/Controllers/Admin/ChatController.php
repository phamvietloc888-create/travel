<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        $threads = ChatThread::with('user')->latest('last_message_at')->paginate(20);
        return view('admin.chats.index', compact('threads'));
    }

    public function show(ChatThread $thread): View
    {
        $thread->load(['user', 'messages.sender']);
        return view('admin.chats.show', compact('thread'));
    }

    public function reply(Request $request, ChatThread $thread): RedirectResponse
    {
        $data = $request->validate(['message' => ['required', 'string']]);
        ChatMessage::create([
            'thread_id' => $thread->id,
            'sender_type' => 'ADMIN',
            'sender_user_id' => $request->user()?->id,
            'message' => $data['message'],
        ]);
        $thread->update(['last_message_at' => now()]);

        return redirect()->route('admin.chats.show', $thread)->with('toast', 'Đã gửi tin nhắn.');
    }
}
