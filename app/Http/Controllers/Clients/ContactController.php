<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $thread = null;
        $messages = collect();
        $chatReady = ChatThread::chatTablesReady();

        if ($chatReady && ($user = $request->user())) {
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

        return view('clients.contact', compact('thread', 'messages', 'chatReady'));
    }

    public function feed(Request $request): JsonResponse
    {
        abort_unless($request->user(), 401);
        abort_unless(ChatThread::chatTablesReady(), 404);

        $thread = ChatThread::query()
            ->with(['messages.sender', 'latestMessage'])
            ->firstOrCreate(
                ['user_id' => $request->user()->id],
                [
                    'status' => 'OPEN',
                    'last_message_at' => now(),
                ]
            );

        $messages = $thread->messages
            ->sortBy('created_at')
            ->values()
            ->map(fn (ChatMessage $message) => [
                'id' => $message->id,
                'sender_type' => strtoupper((string) $message->sender_type),
                'sender_name' => strtoupper((string) $message->sender_type) === 'ADMIN' ? 'Ho tro vien' : 'Ban',
                'message' => $message->message,
                'created_at' => $message->created_at?->format('H:i d/m'),
            ]);

        return response()->json([
            'thread_id' => $thread->id,
            'last_message_id' => $messages->last()['id'] ?? 0,
            'messages' => $messages,
            'needs_admin_reply' => $thread->requiresAdminAttention(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()
                ->route('login')
                ->with('toast', 'Vui lòng đăng nhập để nhắn tin với hỗ trợ.');
        }

        if (! ChatThread::chatTablesReady()) {
            return back()->with('error', 'Tinh nang ho tro dang duoc cap nhat. Vui long thu lai sau.');
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
