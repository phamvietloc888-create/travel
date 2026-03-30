@extends('clients.layout')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ route('home') }}">Trang chu <i class="fa fa-chevron-right"></i></a>
                    </span>
                    <span>Ho tro <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Nhan tin voi ho tro</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="support-chat-wrap">
            @if (session('success'))
                <div class="support-chat-alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="support-chat-alert support-chat-alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @unless($chatReady)
                <div class="support-chat-alert support-chat-alert-warning">
                    Tinh nang ho tro dang duoc cap nhat tren server. Vui long thu lai sau.
                </div>
            @endunless

            @guest
                <div class="support-chat-guest">
                    <div class="support-chat-head">
                        <div>
                            <span class="support-chat-kicker">Lotus Vietnam Travel</span>
                            <h3>Dang nhap de bat dau chat</h3>
                        </div>
                        <span class="support-chat-status">Online</span>
                    </div>

                    <div class="support-chat-empty">
                        <div class="support-chat-avatar">
                            <i class="fa fa-comments"></i>
                        </div>
                        <h4>Khung lien he da doi sang chat</h4>
                        <p>Ban dang nhap la co the gui tin nhan truc tiep va nhan phan hoi tu admin ngay tai day.</p>
                        <div class="support-chat-actions">
                            <a href="{{ route('login') }}" class="btn btn-primary px-4 py-3">Dang nhap</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-dark px-4 py-3">Tao tai khoan</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="support-chat-shell">
                    <div class="support-chat-head">
                        <div>
                            <span class="support-chat-kicker">Ho tro khach hang</span>
                            <h3>{{ auth()->user()->name }}</h3>
                            <p>Gui cau hoi ve tour, booking hoac thanh toan. Khung chat se tu dong cap nhat khi co phan hoi moi.</p>
                        </div>
                        <span class="support-chat-status">Online</span>
                    </div>

                    <div class="support-chat-body" id="supportChatMessages">
                        @forelse ($messages as $message)
                            @php($isAdmin = strtoupper((string) $message->sender_type) === 'ADMIN')
                            <div class="support-chat-row {{ $isAdmin ? 'is-admin' : 'is-user' }}">
                                <div class="support-chat-bubble">
                                    <div class="support-chat-meta">
                                        <span>{{ $isAdmin ? 'Ho tro vien' : 'Ban' }}</span>
                                        <span>{{ $message->created_at?->format('H:i d/m') }}</span>
                                    </div>
                                    <p>{{ $message->message }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="support-chat-empty">
                                <div class="support-chat-avatar">
                                    <i class="fa fa-headphones"></i>
                                </div>
                                <h4>Chua co tin nhan nao</h4>
                                <p>Nhap noi dung ben duoi de bat dau cuoc tro chuyen voi doi ngu ho tro.</p>
                            </div>
                        @endforelse
                    </div>

                    <form action="{{ route('contact.submit') }}" method="POST" class="support-chat-form">
                        @csrf
                        <div class="support-chat-input-wrap">
                            <textarea
                                id="supportChatInput"
                                name="message"
                                rows="2"
                                class="form-control support-chat-input @error('message') is-invalid @enderror"
                                placeholder="Nhap noi dung can ho tro..."
                                @disabled(! $chatReady)
                            >{{ old('message') }}</textarea>
                            <button type="submit" class="btn btn-primary support-chat-send" @disabled(! $chatReady)>Gui</button>
                        </div>
                        <small class="support-chat-note">Khung chat se tu dong cap nhat sau moi 12 giay.</small>
                        @error('message')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </form>
                </div>
            @endguest
        </div>
    </div>
</section>

<style>
    .support-chat-wrap {
        max-width: 920px;
        margin: 0 auto;
    }

    .support-chat-shell,
    .support-chat-guest {
        background: linear-gradient(180deg, #f8fffa 0%, #ffffff 100%);
        border: 4px solid #39b54a;
        border-radius: 24px;
        box-shadow: 0 24px 60px rgba(17, 24, 39, 0.08);
        overflow: hidden;
    }

    .support-chat-alert {
        margin-bottom: 18px;
        padding: 14px 18px;
        border-radius: 16px;
        background: #ecfdf3;
        border: 1px solid #9ee6b3;
        color: #166534;
        font-weight: 600;
    }

    .support-chat-alert-error {
        background: #fff1f2;
        border-color: #fecdd3;
        color: #be123c;
    }

    .support-chat-alert-warning {
        background: #fff7ed;
        border-color: #fdba74;
        color: #c2410c;
    }

    .support-chat-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 24px 28px;
        background: linear-gradient(135deg, #47c95b 0%, #dff8d8 100%);
        border-bottom: 1px solid rgba(57, 181, 74, 0.2);
    }

    .support-chat-head h3 {
        margin: 6px 0 6px;
        font-size: 28px;
        color: #102418;
    }

    .support-chat-head p,
    .support-chat-empty p {
        margin: 0;
        color: #355341;
    }

    .support-chat-kicker {
        display: inline-block;
        font-size: 12px;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        font-weight: 700;
        color: #24592f;
    }

    .support-chat-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.82);
        color: #166534;
        font-weight: 700;
        white-space: nowrap;
    }

    .support-chat-body {
        max-height: 560px;
        overflow-y: auto;
        padding: 24px;
        background:
            radial-gradient(circle at top left, rgba(71, 201, 91, 0.12), transparent 26%),
            radial-gradient(circle at bottom right, rgba(34, 197, 94, 0.08), transparent 22%),
            #f7faf7;
    }

    .support-chat-row {
        display: flex;
        margin-bottom: 18px;
    }

    .support-chat-row.is-admin {
        justify-content: flex-start;
    }

    .support-chat-row.is-user {
        justify-content: flex-end;
    }

    .support-chat-bubble {
        max-width: min(78%, 560px);
        padding: 14px 16px;
        border-radius: 20px;
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
    }

    .support-chat-row.is-admin .support-chat-bubble {
        background: #ffffff;
        border: 1px solid #d2f0d5;
        border-top-left-radius: 8px;
    }

    .support-chat-row.is-user .support-chat-bubble {
        background: linear-gradient(135deg, #39b54a 0%, #22993a 100%);
        color: #ffffff;
        border-top-right-radius: 8px;
    }

    .support-chat-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 6px;
        font-size: 12px;
        opacity: 0.8;
    }

    .support-chat-bubble p {
        margin: 0;
        white-space: pre-line;
        line-height: 1.7;
        font-size: 16px;
    }

    .support-chat-form {
        padding: 20px 24px 24px;
        background: #ffffff;
        border-top: 1px solid #dff1e2;
    }

    .support-chat-input-wrap {
        display: flex;
        gap: 14px;
        align-items: flex-end;
    }

    .support-chat-input {
        min-height: 72px;
        resize: vertical;
        border-radius: 18px !important;
        padding: 18px 20px !important;
        font-size: 16px !important;
        background: #fbfffb !important;
    }

    .support-chat-send {
        min-width: 110px;
        height: 56px;
        border-radius: 16px !important;
        font-weight: 700 !important;
    }

    .support-chat-note {
        display: block;
        margin-top: 10px;
        color: #64748b;
        font-size: 12px;
    }

    .support-chat-guest,
    .support-chat-empty {
        text-align: center;
    }

    .support-chat-empty {
        padding: 34px 20px;
    }

    .support-chat-avatar {
        width: 74px;
        height: 74px;
        margin: 0 auto 16px;
        border-radius: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #39b54a 0%, #7ae582 100%);
        color: #ffffff;
        font-size: 28px;
        box-shadow: 0 20px 32px rgba(57, 181, 74, 0.24);
    }

    .support-chat-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .btn-outline-dark {
        border: 1px solid #111111;
        color: #111111;
        background: transparent;
    }

    .btn-outline-dark:hover,
    .btn-outline-dark:focus {
        background: #111111;
        color: #ffffff;
    }

    @media (max-width: 767.98px) {
        .support-chat-head,
        .support-chat-form {
            padding: 18px;
        }

        .support-chat-input-wrap {
            flex-direction: column;
            align-items: stretch;
        }

        .support-chat-send {
            width: 100%;
        }

        .support-chat-bubble {
            max-width: 92%;
        }
    }
</style>

@auth
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const messagesWrap = document.getElementById('supportChatMessages');
            const input = document.getElementById('supportChatInput');
            let lastMessageId = {{ (int) ($messages->sortBy('created_at')->last()?->id ?? 0) }};

            const renderMessages = (messages) => {
                if (!messagesWrap) {
                    return;
                }

                if (!messages.length) {
                    messagesWrap.innerHTML = `
                        <div class="support-chat-empty">
                            <div class="support-chat-avatar">
                                <i class="fa fa-headphones"></i>
                            </div>
                            <h4>Chua co tin nhan nao</h4>
                            <p>Nhap noi dung ben duoi de bat dau cuoc tro chuyen voi doi ngu ho tro.</p>
                        </div>
                    `;
                    return;
                }

                messagesWrap.innerHTML = messages.map((message) => {
                    const isAdmin = message.sender_type === 'ADMIN';
                    const safeMessage = String(message.message || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');

                    return `
                        <div class="support-chat-row ${isAdmin ? 'is-admin' : 'is-user'}">
                            <div class="support-chat-bubble">
                                <div class="support-chat-meta">
                                    <span>${message.sender_name || (isAdmin ? 'Ho tro vien' : 'Ban')}</span>
                                    <span>${message.created_at || ''}</span>
                                </div>
                                <p>${safeMessage}</p>
                            </div>
                        </div>
                    `;
                }).join('');

                messagesWrap.scrollTop = messagesWrap.scrollHeight;
            };

            const pollFeed = async () => {
                if (input && document.activeElement === input && input.value.trim() !== '') {
                    return;
                }

                try {
                    const response = await fetch(@json(route('contact.feed')), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    });

                    if (!response.ok) {
                        return;
                    }

                    const payload = await response.json();

                    if ((payload.last_message_id || 0) !== lastMessageId) {
                        lastMessageId = payload.last_message_id || 0;
                        renderMessages(payload.messages || []);
                    }
                } catch (error) {
                    console.warn('Support chat polling failed', error);
                }
            };

            window.setInterval(pollFeed, 12000);
        });
    </script>
@endauth
@endsection
