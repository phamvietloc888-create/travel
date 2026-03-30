<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        $chatReady = ChatThread::chatTablesReady();
        $threads = $chatReady
            ? ChatThread::with(['user', 'latestMessage.sender'])->latest('last_message_at')->paginate(20)
            : new LengthAwarePaginator([], 0, 20);

        $attentionCount = $chatReady ? ChatThread::adminAttentionCount() : 0;

        return view('admin.chats.index', compact('threads', 'chatReady', 'attentionCount'));
    }

    public function show(ChatThread $thread): View
    {
        abort_unless(ChatThread::chatTablesReady(), 404);

        $thread->load(['user', 'messages.sender', 'latestMessage.sender']);

        return view('admin.chats.show', compact('thread'));
    }

    public function feed(ChatThread $thread): JsonResponse
    {
        abort_unless(ChatThread::chatTablesReady(), 404);

        $thread->load(['messages.sender', 'latestMessage.sender']);

        $messages = $thread->messages
            ->sortBy('created_at')
            ->values()
            ->map(fn (ChatMessage $message) => [
                'id' => $message->id,
                'sender_type' => strtoupper((string) $message->sender_type),
                'sender_name' => trim(($message->sender_type ?? '').' '.($message->sender?->name ?? '')),
                'message' => $message->message,
                'created_at' => $message->created_at?->format('d/m/Y H:i'),
            ]);

        return response()->json([
            'thread_id' => $thread->id,
            'last_message_id' => $messages->last()['id'] ?? 0,
            'requires_admin_attention' => $thread->requiresAdminAttention(),
            'attention_count' => ChatThread::adminAttentionCount(),
            'messages' => $messages,
        ]);
    }

    public function attentionCount(): JsonResponse
    {
        return response()->json([
            'attention_count' => ChatThread::adminAttentionCount(),
        ]);
    }

    public function reply(Request $request, ChatThread $thread): RedirectResponse
    {
        abort_unless(ChatThread::chatTablesReady(), 404);

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
