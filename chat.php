<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .session-container {

            height: 100%;
            overflow-y: auto;
            /* This makes the session list scrollable */
        }

        .menu {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 25%;
            background: #fff;
            z-index: 1;

        }

        .session-list a {
            color: #000;
            background: #e9e9e9;
            border-radius: 10px;
            margin: 10px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;

        }

        .session-list a:hover {
            background: #d9d9d9;
        }

        .input-area {
            background: #fff;
            border-top: 2px solid #e9e9e9;
            padding: 15px 20px;
            position: fixed;
            bottom: 0;
            right: 0;
            width: 75%;
            display: flex;
            align-items: center;
            z-index: 1;
        }

        .input-area textarea {
            flex: 1;
            border: 2px solid #e9e9e9;
            resize: none;
        }

        .input-area button {
            width: 14%;
            margin-left: 5px;
        }

        .user-icon,
        .ai-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 8px;
            background-color: #ccc;
            display: inline-block;
        }

        .ai-icon {
            background-color: #888;
        }

        .chat-area {
            margin-left: 25%;
            height: calc(100% - 60px);
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <!-- Session List -->
    <div class="menu">
        <div class="p-3 d-flex align-items-center">
            <button class="btn btn-outline-primary mb-2 flex-grow-1">New Chat</button>
            <span class="user-icon ml-2"></span>
        </div>
        <div class="session-container">
            <!-- <div class="p-3 d-flex align-items-center">
            <button class="btn btn-outline-primary mb-2 flex-grow-1">New Chat</button>
            <span class="user-icon ml-2"></span>
        </div> -->
            <div class="flex-grow-1 overflow-auto session-list">
                <!-- Sessions List -->

                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>
                <a href="#" class="text-decoration-none">
                    Session 1
                </a>


            </div>
        </div>
    </div>
    <!-- Chat Area -->
    <div class="chat-area p-4">
        <!-- Chat Messages (History Area) -->


        <div class="mb-3">
            <span class="user-icon"></span>
            <strong>User:</strong> Hello, Assistant!
        </div>
        <div class="mb-3">
            <span class="ai-icon"></span>
            <strong>Assistant:</strong> Hello! How can I help you?
        </div>
        <div class="mb-3">
            <span class="user-icon"></span>
            <strong>User:</strong> Hello, Assistant!
        </div>
        <div class="mb-3">
            <span class="ai-icon"></span>
            <strong>Assistant:</strong> Hello! How can I help you?
        </div>
        <div class="mb-3">
            <span class="user-icon"></span>
            <strong>User:</strong> Hello, Assistant!
        </div>
        <div class="mb-3">
            <span class="ai-icon"></span>
            <strong>Assistant:</strong> Hello! How can I help you?
        </div>
        <div class="mb-3">
            <span class="user-icon"></span>
            <strong>User:</strong> Hello, Assistant!
        </div>
        <div class="mb-3">
            <span class="ai-icon"></span>
            <strong>Assistant:</strong> Hello! How can I help you?
        </div>
        <div class="mb-3">
            <span class="user-icon"></span>
            <strong>User:</strong> Hello, Assistant!
        </div>
        <div class="mb-3">
            <span class="ai-icon"></span>
            <strong>Assistant:</strong> Hello! How can I help you?
        </div>
        <div class="mb-3">
            <span class="user-icon"></span>
            <strong>User:</strong> Hello, Assistant!
        </div>
        <div class="mb-3">
            <span class="ai-icon"></span>
            <strong>Assistant:</strong> Hello! How can I help you?
        </div>
        <div class="mb-3">
            <span class="user-icon"></span>
            <strong>User:</strong> Hello, Assistant!
        </div>
        <div class="mb-3">
            <span class="ai-icon"></span>
            <strong>Assistant:</strong> Hello! How can I help you?
        </div>
        <div class="mb-3">
            <span class="user-icon"></span>
            <strong>User:</strong> Hello, Assistant!
        </div>
        <div class="mb-3">
            <span class="ai-icon"></span>
            <strong>Assistant:</strong> Hello! How can I help you?
        </div>

    </div>

    <!-- Input Area for User Messages -->
    <div class="input-area">
        <textarea class="form-control" rows="1" placeholder="Type your message here..."></textarea>
        <button class="btn btn-primary">
            <i class="bi bi-arrow-right-circle-fill"></i>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>