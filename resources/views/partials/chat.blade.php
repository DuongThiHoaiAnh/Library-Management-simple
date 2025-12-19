<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chatbot Thư viện</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #chatbot-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #6F27F4;
            color: white;
            font-size: 22px;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 9999;
        }

        #chatbot {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 350px;
            display: none;
            z-index: 9999;
        }

        .chat-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .chat-header {
            padding: 10px;
            background: #e1eef9ff;
            color: #000000ff;
            font-weight: bold;
        }

        .chat-box {
            height: 300px;
            overflow-y: auto;
            padding: 10px;
            gap: 15px;
        }

        .user {
            text-align: right;
            color: #2980b9;
        }

        .bot {
            text-align: left;
            color: #2c3e50;
        }

        .chat-input {
            display: flex;
            border-top: 1px solid #ddd;
        }

        .chat-input input {
            flex: 1;
            padding: 8px;
            border: none;
            outline: none;
        }

        .chat-input button {
            padding: 8px 12px;
            background: #6F27F4;
            border: none;
            color: white;
        }
    </style>

</head>

<body>

    <div id="chatbot-toggle" onclick="toggleChat()">💭</div>

    <div class="chat-container" id="chatbot">
        <div class="chat-header">
            📚 Chatbot Tư vấn
            <span onclick="toggleChat()" style="float:right;cursor:pointer;">✖</span>
        </div>

        <div class="chat-box" id="chatBox">
            <p class="bot"><b>Bot:</b> Xin chào! Tôi có thể giúp bạn tư vấn sách phù hợp với bản thân.</p>
        </div>

        <div class="chat-input">
            <input type="text" id="message" placeholder="Hỏi về sách..." />
            <button onclick="sendMessage()">Gửi</button>
        </div>
    </div>


    <script>
        function toggleChat() {
            const chat = document.getElementById('chatbot');
            chat.style.display = chat.style.display === 'none' ? 'block' : 'none';
        }

        function sendMessage() {
            let input = document.getElementById('message');
            let chatBox = document.getElementById('chatBox');
            let message = input.value.trim();
            if (!message) return;

            chatBox.innerHTML += `<p class="user"><b>Bạn:</b> ${message}</p>`;
            input.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;

            fetch("{{ route('chat.send') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message
                    })
                })
                .then(res => res.json())
                .then(data => {
                    chatBox.innerHTML += `<p class="bot"><b>Bot:</b> ${data.reply}</p>`;
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        }
    </script>


</body>

</html>