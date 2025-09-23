<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Jubileu - Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #1e1e1e;
            --bg-secondary: #252526;
            --bg-tertiary: #2d2d30;
            --primary: #007acc;
            --text-primary: #d4d4d4;
            --text-secondary: #cccccc;
            --accent: #4ec9b0;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            background-color: var(--bg-secondary);
            height: 100vh;
            border-right: 1px solid var(--bg-tertiary);
        }

        .chat-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        .message {
            max-width: 80%;
            margin-bottom: 1rem;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-message {
            margin-left: auto;
            background-color: var(--primary);
            color: white;
            border-radius: 18px 18px 4px 18px;
        }

        .bot-message {
            background-color: var(--bg-tertiary);
            border-radius: 18px 18px 18px 4px;
        }

        .message-content {
            padding: 0.75rem 1rem;
        }

        .message-time {
            font-size: 0.7rem;
            opacity: 0.7;
            margin-top: 0.25rem;
        }

        .code-block {
            background-color: var(--bg-primary);
            border-radius: 4px;
            padding: 1rem;
            margin: 0.5rem 0;
            position: relative;
        }

        .composer {
            background-color: var(--bg-secondary);
            border-top: 1px solid var(--bg-tertiary);
            padding: 1rem;
        }

        .conversation-item {
            padding: 0.75rem;
            border-bottom: 1px solid var(--bg-tertiary);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .conversation-item:hover {
            background-color: var(--bg-tertiary);
        }

        .conversation-item.active {
            background-color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="d-flex flex-column h-100">
                    <div class="p-3 border-bottom">
                        <h5 class="mb-0">
                            <i class="fas fa-robot me-2"></i>Professor Jubileu
                        </h5>
                    </div>

                    <div class="p-3">
                        <a href="{{ route('chat.new') }}" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-plus me-2"></i>Nova Conversa
                        </a>
                    </div>

                    <div class="flex-grow-1 overflow-auto">
                        <h6 class="px-3 mb-2 text-muted">Conversas Anteriores</h6>
                        @foreach($conversations as $conv)
                            <div class="conversation-item {{ $currentConversation && $currentConversation->id == $conv->id ? 'active' : '' }}"
                                 onclick="loadConversation({{ $conv->id }})">
                                <div class="fw-bold">{{ $conv->title }}</div>
                                <small class="text-muted">{{ $conv->last_message_time->format('d/m/Y H:i') }}</small>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-3 border-top">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-md-9 col-lg-10 p-0">
                <div class="chat-container">
                    <!-- Header -->
                    <div class="border-bottom bg-secondary p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-robot text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Professor Jubileu</h5>
                                    <small class="text-success">
                                        <i class="fas fa-circle me-1"></i>Online
                                    </small>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-outline-light me-2" id="pdf-btn">
                                    <i class="fas fa-file-pdf me-1"></i>PDF
                                </button>
                                <button class="btn btn-outline-light" id="clear-btn">
                                    <i class="fas fa-trash me-1"></i>Limpar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="messages-container" id="messages-container">
                        @if(!$currentConversation)
                            <div class="text-center text-muted mt-5">
                                <i class="fas fa-robot fa-3x mb-3"></i>
                                <h3>Olá! Eu sou o Professor Jubileu</h3>
                                <p>Estou aqui para ajudá-lo a aprender programação. Como posso ajudar hoje?</p>
                            </div>
                        @else
                            @foreach($messages as $message)
                                <div class="message {{ $message->sender === 'user' ? 'user-message' : 'bot-message' }}">
                                    <div class="message-content">
                                        {!! $message->content !!}
                                        <div class="message-time">
                                            {{ $message->created_at->format('H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- PDF Preview -->
                    <div class="pdf-preview bg-tertiary p-3 border-top" id="pdf-preview" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0"><i class="fas fa-file-pdf me-2"></i>PDF Carregado</h6>
                            <button class="btn btn-sm btn-outline-light" id="remove-pdf-btn">
                                <i class="fas fa-times me-1"></i>Remover
                            </button>
                        </div>
                        <div class="pdf-content small" id="pdf-content"></div>
                    </div>

                    <!-- Typing Indicator -->
                    <div class="typing-indicator bg-tertiary p-3" id="typing-indicator" style="display: none;">
                        <div class="d-flex align-items-center">
                            <span class="me-2">Professor Jubileu está digitando</span>
                            <div class="typing-dots">
                                <span class="dot"></span>
                                <span class="dot"></span>
                                <span class="dot"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Composer -->
                    <div class="composer">
                        <div class="input-group">
                            <input type="file" id="file-input" accept=".pdf" style="display: none;">
                            <button class="btn btn-outline-light" type="button" id="attach-btn">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <textarea class="form-control bg-dark text-light border-0"
                                      id="message-input"
                                      placeholder="Digite sua mensagem..."
                                      rows="1"></textarea>
                            <button class="btn btn-primary" type="button" id="send-btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentConversationId = {{ $currentConversation ? $currentConversation->id : 'null' }};

        // Event Listeners
        document.getElementById('send-btn').addEventListener('click', sendMessage);
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        document.getElementById('attach-btn').addEventListener('click', () => {
            document.getElementById('file-input').click();
        });

        document.getElementById('file-input').addEventListener('change', uploadPdf);
        document.getElementById('pdf-btn').addEventListener('click', () => {
            document.getElementById('file-input').click();
        });

        document.getElementById('clear-btn').addEventListener('click', clearChat);

        // Funções
        async function sendMessage() {
            const messageInput = document.getElementById('message-input');
            const message = messageInput.value.trim();

            if (!message) return;

            addMessage(message, 'user');
            messageInput.value = '';
            showTypingIndicator();

            try {
                const response = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: message,
                        conversation_id: currentConversationId
                    })
                });

                const data = await response.json();
                hideTypingIndicator();

                if (data.success) {
                    currentConversationId = data.conversation_id;
                    addMessage(data.bot_response, 'bot');
                }
            } catch (error) {
                hideTypingIndicator();
                addMessage('Desculpe, ocorreu um erro. Tente novamente.', 'bot');
            }
        }

        async function uploadPdf(event) {
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('pdf', file);
            formData.append('conversation_id', currentConversationId);

            try {
                const response = await fetch('{{ route("chat.upload-pdf") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    currentConversationId = data.conversation_id;
                    showPdfPreview(data.pdf_content);
                    addMessage(`PDF carregado com sucesso! Agora você pode fazer perguntas sobre o conteúdo.`, 'bot');
                }
            } catch (error) {
                alert('Erro ao carregar PDF');
            }
        }

        function addMessage(content, sender) {
            const messagesContainer = document.getElementById('messages-container');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;

            messageDiv.innerHTML = `
                <div class="message-content">
                    ${formatMessage(content)}
                    <div class="message-time">${new Date().toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'})}</div>
                </div>
            `;

            messagesContainer.appendChild(messageDiv);
            scrollToBottom();
        }

        function formatMessage(text) {
            // Implementar formatação similar ao original
            return text.replace(/\n/g, '<br>');
        }

        function showPdfPreview(content) {
            const preview = document.getElementById('pdf-preview');
            const contentDiv = document.getElementById('pdf-content');
            contentDiv.textContent = content;
            preview.style.display = 'block';
        }

        function showTypingIndicator() {
            document.getElementById('typing-indicator').style.display = 'block';
            scrollToBottom();
        }

        function hideTypingIndicator() {
            document.getElementById('typing-indicator').style.display = 'none';
        }

        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        }

        function loadConversation(conversationId) {
            window.location.href = `{{ url('chat') }}/${conversationId}`;
        }

        function clearChat() {
            if (confirm('Tem certeza que deseja limpar esta conversa?')) {
                if (currentConversationId) {
                    fetch(`{{ url('chat/delete') }}/${currentConversationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                }
                window.location.href = '{{ route("chat.new") }}';
            }
        }
    </script>
</body>
</html>
