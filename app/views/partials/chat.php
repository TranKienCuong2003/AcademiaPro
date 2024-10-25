<?php
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Người dùng';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Bot</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <style>
        @keyframes shake {
            0%, 100% { transform: translate(0); }
            20%, 60% { transform: translate(-2px, 0); }
            40%, 80% { transform: translate(2px, 0); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.2); opacity: 0.9; }
        }

        #chat-icon {
            animation: shake 2s infinite;
            cursor: pointer;
            position: relative;
            width: 70px;
            height: 70px;
            z-index: 1000;
            opacity: 1;
            transition: opacity 0.5s;
        }

        #chat-icon::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            background: rgba(156, 39, 176, 0.5);
            top: -14px;
            left: -14px;
            transform: translate(-50%, -50%);
            animation: pulse 2s infinite;
            z-index: -1;
        }

        #chat-icon:hover::after {
            opacity: 1;
        }

        #chat-window {
            display: none;
            opacity: 0;
            transition: opacity 0.5s;
            z-index: 1000;
        }

        .message-user {
            background-color: #007bff;
            color: #fff;
            text-align: right;
        }

        .message-bot {
            background-color: #e9ecef;
            text-align: left;
        }

        .message-container {
            margin-bottom: 10px;
        }

        .username, .bot-username {
            font-size: 0.8em; color: red;
        }

        .close.text-white {
            outline: none;
        }
    </style>
</head>
<body>

<!-- Chat Icon -->
<div id="chat-icon" class="position-fixed" style="bottom: 100px; right: 60px;" onclick="toggleChatWindow()">
    <img src="/public/assets/imgages/chat-svgrepo-com.svg" alt="Chat" class="img-fluid" style="width: 70px;">
</div>

<!-- Chat Window -->
<div id="chat-window" class="card position-fixed" style="bottom: 80px; right: 60px; width: 350px;">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="border-radius: 40px 40px 0 0;">
        <strong>Chat Bot</strong>
        <button class="close text-white" onclick="toggleChatWindow()">&times;</button>
    </div>
    <div id="chat-messages" class="card-body" style="height: 250px; overflow-y: auto;">
        <div class="message-container">
            <div class="bot-username"><strong>Bot:</strong></div>
            <div class="message-bot p-2 rounded">
                Xin chào <span class="text-danger font-weight-bold"><?php echo $username; ?></span>, mình là Chat Bot của hệ thống Quản lý Giáo dục AcademiaPro. Mình có thể giúp gì cho bạn?
            </div>
        </div>
    </div>
    <div class="card-footer d-flex">
        <input type="text" id="user-message" class="form-control" placeholder="Nhập tin nhắn..." onkeydown="checkEnter(event)">
        <button class="btn btn-light ml-2" onclick="sendMessage()">
            <i class="fas fa-paper-plane"></i> Gửi
        </button>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Vui lòng nhập tin nhắn trước khi gửi.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    const currentUsername = "<?php echo $username; ?>";

    function toggleChatWindow() {
        const chatWindow = document.getElementById("chat-window");
        const chatIcon = document.getElementById("chat-icon");

        if (chatWindow.style.display === "none" || chatWindow.style.display === "") {
            chatWindow.style.display = "block";
            setTimeout(() => {
                chatWindow.style.opacity = 1;
            }, 10);
            chatIcon.style.opacity = 0;
        } else {
            chatWindow.style.opacity = 0;
            setTimeout(() => {
                chatWindow.style.display = "none";
            }, 500);
            chatIcon.style.opacity = 1;
        }
    }

    function sendMessage() {
        const messageInput = document.getElementById("user-message");
        const message = messageInput.value.trim();

        if (!message) {
            $('#alertModal').modal('show'); 
            return;
        }

        appendMessage(currentUsername, message, 'message-user');
        const response = generateResponse(message);
        appendMessage('Bot', response, 'message-bot');

        messageInput.value = "";
        scrollToBottom();
    }

    function appendMessage(sender, message, messageClass) {
        const chatMessages = document.getElementById("chat-messages");
        chatMessages.innerHTML += `
            <div class="message-container">
                <div class="${sender === 'Bot' ? 'bot-username' : 'username'}">
                    <strong class="text-danger">${sender}:</strong>
                </div>
                <div class="${messageClass} mb-2 p-2 rounded">${message}</div>
            </div>`;
    }

    function scrollToBottom() {
        const chatMessages = document.getElementById("chat-messages");
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function checkEnter(event) {
        if (event.key === 'Enter') sendMessage();
    }

    function generateResponse(message) {
        const keywords = [
            { key: ["giảng viên", "thông tin giảng viên"], response: "Bạn có thể quản lý thông tin giảng viên tại mục Quản lý Giảng viên." },
            { key: ["academiapro", "giới thiệu"], response: "AcademiaPro là hệ thống quản lý giáo dục đa chức năng." },
            { key: ["sinh viên", "thông tin sinh viên"], response: "Thông tin sinh viên được quản lý tại mục Quản lý Sinh viên." },
            { key: ["môn học"], response: "Bạn có thể quản lý môn học tại mục Quản lý Môn học." },
            { key: ["xin chào"], response: "Xin chào! Mình có thể giúp gì cho bạn?" },
            { key: ["điểm sinh viên"], response: "Điểm sinh viên được quản lý tại mục Quản lý Điểm." },
            { key: ["tìm kiếm"], response: "Vui lòng cung cấp từ khóa để tìm kiếm." },
            { key: ["hướng dẫn"], response: "Bạn có thể hỏi về Giảng viên, Sinh viên, Môn học hoặc Điểm." },
            { key: [], response: "Xin lỗi, mình chưa hiểu câu hỏi của bạn! Nếu câu hỏi của bạn liên quan đến các vấn đề của hệ thống vui lòng liên hệ qua số điện thoại 0369702376 hoặc email trankiencuong30072003@gmail.com để được hỗ trợ" }
        ];

        for (const { key, response } of keywords) {
            if (key.some(k => message.toLowerCase().includes(k))) {
                return response;
            }
        }
        return keywords[keywords.length - 1].response;
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
