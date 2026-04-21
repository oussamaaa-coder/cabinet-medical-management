@extends('layouts.sidebar')

@section('title', 'Chat de Groupe')
<link rel="icon" type="image/svg+xml" href="{{ asset('asset/img/logo.svg') }}">

@section('content')
    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px);
            background: #f8fafc;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            margin: 20px;
        }

        .chat-header {
            padding: 15px 25px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .message {
            display: flex;
            gap: 12px;
            max-width: 80%;
        }

        .message.own {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            background: #e2e8f0;
        }

        .message-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .message-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #64748b;
        }

        .message.own .message-info {
            flex-direction: row-reverse;
        }

        .user-name {
            font-weight: 600;
            color: #334155;
        }

        .message-bubble {
            padding: 10px 16px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.5;
            position: relative;
        }

        .message.own .message-bubble {
            background: #2563eb;
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .message:not(.own) .message-bubble {
            background: #fff;
            color: #1e293b;
            border: 1px solid #e2e8f0;
            border-top-left-radius: 4px;
        }

        .chat-footer {
            padding: 20px 25px;
            background: #fff;
            border-top: 1px solid #e2e8f0;
        }

        .message-form {
            display: flex;
            gap: 12px;
        }

        .message-input {
            flex: 1;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 10px 20px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .message-input:focus {
            border-color: #2563eb;
            background: #fff;
        }

        .send-btn {
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            flex-shrink: 0;
        }

        .send-btn:hover {
            background: #1d4ed8;
        }

        .send-btn:active {
            transform: scale(0.95);
        }

        /* Scrollbar Styling */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>

    <div class="chat-container">
        <div class="chat-header">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="width: 24px; color: #2563eb;">
                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
            </svg>
            <h2>Discussion de Groupe</h2>
        </div>

        <div class="chat-messages" id="chat-messages">
            <!-- Messages loaded via AJAX -->
        </div>

        <div class="chat-footer">
            <form id="chat-form" class="message-form">
                @csrf
                <input type="text" id="message-input" name="content" class="message-input"
                    placeholder="Tapez votre message ici..." autocomplete="off">
                <button type="submit" class="send-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 20px;">
                        <line x1="22" y1="2" x2="11" y2="13" />
                        <polyline points="22 2 15 22 11 13 2 9 22 2" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const currentUserId = {{ auth()->id() }};
        const chatMessages = $('#chat-messages');
        const chatForm = $('#chat-form');
        const messageInput = $('#message-input');

        function fetchMessages() {
            $.ajax({
                url: "{{ route('chat.messages') }}",
                method: 'GET',
                success: function (messages) {
                    let html = '';
                    messages.forEach(msg => {
                        const isOwn = msg.user_id === currentUserId;
                        const photo = msg.user.profile_photo ? `/profiles/${msg.user.profile_photo}` : 'https://ui-avatars.com/api/?name=' + msg.user.name;
                        const date = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                        html += `
                            <div class="message ${isOwn ? 'own' : ''}">
                                <img src="${photo}" class="message-avatar" alt="${msg.user.name}">
                                <div class="message-content">
                                    <div class="message-info">
                                        <span class="user-name">${msg.user.name}</span>
                                        <span class="message-time">${date}</span>
                                    </div>
                                    <div class="message-bubble">
                                        ${msg.content}
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    const isAtBottom = chatMessages.scrollTop() + chatMessages.innerHeight() >= chatMessages[0].scrollHeight - 50;
                    chatMessages.html(html);

                    if (isAtBottom) {
                        scrollToBottom();
                    }
                }
            });
        }

        function scrollToBottom() {
            chatMessages.scrollTop(chatMessages[0].scrollHeight);
        }

        chatForm.on('submit', function (e) {
            e.preventDefault();
            const content = messageInput.val().trim();
            if (!content) return;

            $.ajax({
                url: "{{ route('chat.store') }}",
                method: 'POST',
                data: {
                    content: content,
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    messageInput.val('');
                    fetchMessages();
                    setTimeout(scrollToBottom, 50);
                }
            });
        });

        // Initial fetch
        fetchMessages();
        setTimeout(scrollToBottom, 500);

        // Polling every 3 seconds
        setInterval(fetchMessages, 3000);
    </script>
@endsection