@php
    use App\Models\ChatThread;

    $chatMessages = collect();
    $chatReady = ChatThread::chatTablesReady();

    if ($chatReady && auth()->check()) {
        $chatThread = ChatThread::query()
            ->with(['messages.sender'])
            ->firstOrCreate(
                ['user_id' => auth()->id()],
                [
                    'status' => 'OPEN',
                    'last_message_at' => now(),
                ]
            );

        $chatMessages = $chatThread->messages->sortBy('created_at')->values();
    }
@endphp

<div class="site-chat-widget" data-chat-widget>
    <button
        type="button"
        class="site-chat-toggle"
        data-chat-toggle
        aria-expanded="false"
        aria-controls="siteChatPanel"
    >
        <span class="site-chat-toggle-icon"><i class="fa fa-comments"></i></span>
        <span class="site-chat-toggle-label">Hỗ trợ</span>
    </button>

    <div class="site-chat-panel" id="siteChatPanel" data-chat-panel hidden>
        <div class="site-chat-panel-head">
            <div>
                <span class="site-chat-kicker">Lotus Vietnam Travel</span>
                <h3>Hỗ trợ trực tuyến</h3>
                <p>Gửi tin nhắn cho đội ngũ hỗ trợ ngay tại đây.</p>
            </div>
            <button type="button" class="site-chat-close" data-chat-close aria-label="Đóng chat">
                <i class="fa fa-times"></i>
            </button>
        </div>

        @guest
            <div class="site-chat-guest">
                <div class="site-chat-guest-icon"><i class="fa fa-headset"></i></div>
                <h4>Đăng nhập để bắt đầu chat</h4>
                <p>Bạn sẽ gửi và nhận phản hồi trực tiếp với quản trị viên trong hộp chat này.</p>
                <div class="site-chat-guest-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary px-4 py-3">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-dark px-4 py-3">Đăng ký</a>
                </div>
            </div>
        @else
            <div class="site-chat-panel-body" data-chat-scroll>
                @forelse ($chatMessages as $message)
                    @php($isAdmin = strtoupper((string) $message->sender_type) === 'ADMIN')
                    <div class="site-chat-message {{ $isAdmin ? 'is-admin' : 'is-user' }}">
                        <div class="site-chat-bubble">
                            <div class="site-chat-meta">
                                <span>{{ $isAdmin ? 'Hỗ trợ viên' : 'Bạn' }}</span>
                                <span>{{ $message->created_at?->format('H:i d/m') }}</span>
                            </div>
                            <p>{{ $message->message }}</p>
                        </div>
                    </div>
                @empty
                    <div class="site-chat-empty">
                        <div class="site-chat-empty-icon"><i class="fa fa-comments-o"></i></div>
                        <p>Chưa có tin nhắn nào. Bạn có thể hỏi về tour, lịch đi, giá hoặc thanh toán.</p>
                    </div>
                @endforelse
            </div>

            <form action="{{ route('contact.submit') }}" method="POST" class="site-chat-form">
                @csrf
                <div class="site-chat-input-row">
                    <textarea
                        name="message"
                        rows="2"
                        class="form-control site-chat-input @error('message') is-invalid @enderror"
                        placeholder="Nhập nội dung cần hỗ trợ..."
                    >{{ old('message') }}</textarea>
                    <button type="submit" class="btn btn-primary site-chat-send">Gửi</button>
                </div>
                @error('message')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
            </form>
        @endguest
    </div>
</div>

<style>
    .site-chat-widget {
        position: fixed;
        right: 22px;
        bottom: 22px;
        z-index: 1055;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .site-chat-toggle {
        border: 1px solid rgba(255, 255, 255, 0.65);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px 8px 8px;
        border-radius: 999px;
        background: linear-gradient(135deg, #0f5fc4 0%, #3c9bff 100%);
        color: #fff;
        box-shadow: 0 18px 34px rgba(16, 72, 140, 0.22);
        font-weight: 700;
        backdrop-filter: blur(10px);
        transition: transform 0.24s ease, box-shadow 0.24s ease, opacity 0.24s ease, visibility 0.24s ease;
    }

    .site-chat-toggle.is-hidden {
        opacity: 0;
        pointer-events: none;
        visibility: hidden;
        transform: translateY(8px) scale(0.96);
    }

    .site-chat-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 40px rgba(16, 72, 140, 0.26);
    }

    .site-chat-toggle-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.22);
        font-size: 18px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
    }

    .site-chat-toggle-label {
        font-size: 18px;
        letter-spacing: 0.01em;
    }

    .site-chat-panel {
        width: min(420px, calc(100vw - 24px));
        position: absolute;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.96);
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid rgba(212, 225, 244, 0.9);
        box-shadow: 0 26px 60px rgba(15, 23, 42, 0.14);
        backdrop-filter: blur(14px);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(12px) scale(0.98);
        transform-origin: bottom right;
        transition: opacity 0.24s ease, transform 0.24s ease, visibility 0.24s ease;
    }

    .site-chat-panel.is-open {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(-12px) scale(1);
    }

    .site-chat-panel-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 18px 20px 16px;
        background:
            radial-gradient(circle at top left, rgba(104, 174, 255, 0.22), transparent 36%),
            linear-gradient(180deg, #f4f9ff 0%, #eaf3ff 100%);
        border-bottom: 1px solid #e2ecf8;
    }

    .site-chat-kicker {
        display: inline-block;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #0057b8;
    }

    .site-chat-panel-head h3 {
        margin: 4px 0 4px;
        font-size: 20px;
        color: #102a43;
        line-height: 1.2;
    }

    .site-chat-panel-head p {
        margin: 0;
        font-size: 13px;
        color: #486581;
        line-height: 1.55;
        max-width: 280px;
    }

    .site-chat-close {
        width: 36px;
        height: 36px;
        border: 1px solid rgba(213, 226, 243, 0.95);
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.88);
        color: #102a43;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        transition: background 0.18s ease, transform 0.18s ease;
    }

    .site-chat-close:hover {
        background: #ffffff;
        transform: rotate(90deg);
    }

    .site-chat-panel-body {
        max-height: 380px;
        overflow-y: auto;
        padding: 18px 18px 12px;
        background:
            radial-gradient(circle at top left, rgba(0, 87, 184, 0.05), transparent 24%),
            linear-gradient(180deg, #f9fbff 0%, #ffffff 100%);
    }

    .site-chat-message {
        display: flex;
        margin-bottom: 14px;
    }

    .site-chat-message.is-admin {
        justify-content: flex-start;
    }

    .site-chat-message.is-user {
        justify-content: flex-end;
    }

    .site-chat-bubble {
        max-width: 84%;
        padding: 12px 14px 13px;
        border-radius: 18px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
    }

    .site-chat-message.is-admin .site-chat-bubble {
        background: #ffffff;
        border: 1px solid #e2ebf5;
        border-top-left-radius: 10px;
    }

    .site-chat-message.is-user .site-chat-bubble {
        background: linear-gradient(135deg, #1565d8 0%, #2f80ed 100%);
        color: #fff;
        border-top-right-radius: 10px;
    }

    .site-chat-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 6px;
        font-size: 11px;
        opacity: 0.76;
    }

    .site-chat-bubble p {
        margin: 0;
        white-space: pre-line;
        line-height: 1.6;
        font-size: 14px;
    }

    .site-chat-form {
        padding: 14px 16px 16px;
        border-top: 1px solid #ecf2f9;
        background: rgba(255, 255, 255, 0.96);
    }

    .site-chat-input-row {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }

    .site-chat-input {
        min-height: 58px;
        resize: none;
        border-radius: 18px !important;
        padding: 15px 18px !important;
        font-size: 14px !important;
        border: 1px solid #dbe7f4 !important;
        background: #fbfdff !important;
        box-shadow: none !important;
    }

    .site-chat-send {
        min-width: 84px;
        height: 48px;
        border-radius: 16px !important;
        font-weight: 700 !important;
        box-shadow: none !important;
    }

    .site-chat-guest,
    .site-chat-empty {
        padding: 28px 22px 30px;
        text-align: center;
    }

    .site-chat-guest h4,
    .site-chat-empty p {
        color: #102a43;
    }

    .site-chat-guest p,
    .site-chat-empty p {
        margin-bottom: 0;
        line-height: 1.7;
        color: #486581;
    }

    .site-chat-guest-icon,
    .site-chat-empty-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: linear-gradient(135deg, #0057b8 0%, #4fb0ff 100%);
        color: #fff;
        font-size: 26px;
        box-shadow: 0 18px 32px rgba(0, 87, 184, 0.22);
    }

    .site-chat-guest-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    @media (max-width: 767.98px) {
        .site-chat-widget {
            right: 12px;
            bottom: 12px;
        }

        .site-chat-toggle-label {
            display: none;
        }

        .site-chat-toggle {
            padding-right: 10px;
        }

        .site-chat-panel {
            width: min(100vw - 16px, 390px);
            border-radius: 24px;
            right: 0;
            bottom: 0;
        }

        .site-chat-input-row {
            flex-direction: column;
            align-items: stretch;
        }

        .site-chat-send {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const widget = document.querySelector('[data-chat-widget]');

        if (!widget) {
            return;
        }

        const toggle = widget.querySelector('[data-chat-toggle]');
        const panel = widget.querySelector('[data-chat-panel]');
        const closeBtn = widget.querySelector('[data-chat-close]');
        const scrollArea = widget.querySelector('[data-chat-scroll]');

        const openPanel = () => {
            panel.hidden = false;
            requestAnimationFrame(() => {
                panel.classList.add('is-open');
            });
            toggle.setAttribute('aria-expanded', 'true');
            toggle.classList.add('is-hidden');
            if (scrollArea) {
                scrollArea.scrollTop = scrollArea.scrollHeight;
            }
        };

        const closePanel = () => {
            panel.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.classList.remove('is-hidden');
            window.setTimeout(() => {
                if (!panel.classList.contains('is-open')) {
                    panel.hidden = true;
                }
            }, 240);
        };

        toggle?.addEventListener('click', function () {
            if (panel.hidden) {
                openPanel();
                return;
            }

            closePanel();
        });

        closeBtn?.addEventListener('click', closePanel);

        @if ($errors->has('message') || session('success'))
            openPanel();
        @endif
    });
</script>
