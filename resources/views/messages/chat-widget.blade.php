<div id="chat-widget-container">
    <!-- Floating Chat Button -->
    <button id="chat-toggle-btn" class="btn btn-primary rounded-circle shadow" style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; z-index: 1000; display: flex; align-items: center; justify-content: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
            <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
        </svg>
    </button>

    <!-- Chat Modal -->
    <div id="chat-modal" class="card shadow" style="display: none; position: fixed; bottom: 90px; right: 20px; width: 350px; height: 450px; z-index: 1000; flex-direction: column; overflow: hidden;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0" id="chat-header-title">Course Chat</h6>
            <button id="chat-close-btn" class="btn-close btn-close-white" style="font-size: 0.8rem;"></button>
        </div>
        
        <!-- Teacher View: Student List -->
        @if(auth()->user()->role === 'teacher')
            <div id="student-list-container" class="card-body overflow-auto" style="flex: 1; padding: 0;">
                <div class="list-group list-group-flush" id="student-list">
                    <div class="text-center p-3 text-muted">Loading students...</div>
                </div>
            </div>
        @endif

        <!-- Chat Conversation View -->
        <div id="chat-conversation-container" class="card-body d-flex flex-column" style="flex: 1; padding: 0; background-color: #f8f9fa; {{ auth()->user()->role === 'teacher' ? 'display: none !important;' : '' }}">
            @if(auth()->user()->role === 'teacher')
                <div class="bg-light p-2 border-bottom d-flex align-items-center">
                    <button id="back-to-students-btn" class="btn btn-sm btn-link text-decoration-none px-1 py-0 me-2">← Back</button>
                    <span id="current-chat-student-name" class="fw-bold" style="font-size: 0.9rem;">Student Name</span>
                </div>
            @endif
            
            <div id="chat-messages" class="overflow-auto p-3" style="flex: 1;">
                <div class="text-center text-muted small">Loading messages...</div>
            </div>

            <div class="p-2 border-top bg-white">
                <form id="chat-form" class="d-flex">
                    <input type="hidden" id="chat-receiver-id" value="">
                    <input type="text" id="chat-input" class="form-control form-control-sm me-2" placeholder="Type a message..." required autocomplete="off">
                    <button type="submit" class="btn btn-primary btn-sm">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggleBtn = document.getElementById('chat-toggle-btn');
    const chatModal = document.getElementById('chat-modal');
    const chatCloseBtn = document.getElementById('chat-close-btn');
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const receiverInput = document.getElementById('chat-receiver-id');
    
    const courseId = {{ $course->id }};
    const authUserId = {{ auth()->id() }};
    const authUserRole = '{{ auth()->user()->role }}';
    
    // UI elements for teacher view
    const studentListContainer = document.getElementById('student-list-container');
    const studentList = document.getElementById('student-list');
    const chatConversationContainer = document.getElementById('chat-conversation-container');
    const backToStudentsBtn = document.getElementById('back-to-students-btn');
    const currentChatStudentName = document.getElementById('current-chat-student-name');

    let chatInterval;

    // Toggle Chat Modal
    chatToggleBtn.addEventListener('click', () => {
        chatModal.style.display = chatModal.style.display === 'none' ? 'flex' : 'none';
        if (chatModal.style.display === 'flex') {
            initChat();
        } else {
            clearInterval(chatInterval);
        }
    });

    chatCloseBtn.addEventListener('click', () => {
        chatModal.style.display = 'none';
        clearInterval(chatInterval);
    });

    function initChat() {
        if (authUserRole === 'student') {
            loadMessages();
            chatInterval = setInterval(loadMessages, 5000);
        } else if (authUserRole === 'teacher') {
            studentListContainer.style.display = 'block';
            chatConversationContainer.style.setProperty('display', 'none', 'important');
            loadStudents();
        }
    }

    if (backToStudentsBtn) {
        backToStudentsBtn.addEventListener('click', () => {
            clearInterval(chatInterval);
            chatConversationContainer.style.setProperty('display', 'none', 'important');
            studentListContainer.style.display = 'block';
            loadStudents();
        });
    }

    // Load Students (Teacher only)
    function loadStudents() {
        fetch(`/courses/${courseId}/messages`)
            .then(res => res.json())
            .then(data => {
                if (data.students) {
                    studentList.innerHTML = '';
                    if (data.students.length === 0) {
                        studentList.innerHTML = '<div class="text-center p-3 text-muted small">No students enrolled yet.</div>';
                        return;
                    }
                    data.students.forEach(student => {
                        const btn = document.createElement('button');
                        btn.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
                        btn.innerHTML = `${student.name}`;
                        btn.onclick = () => openTeacherStudentChat(student.id, student.name);
                        studentList.appendChild(btn);
                    });
                }
            });
    }

    function openTeacherStudentChat(studentId, studentName) {
        receiverInput.value = studentId;
        currentChatStudentName.innerText = studentName;
        studentListContainer.style.display = 'none';
        chatConversationContainer.style.setProperty('display', 'flex', 'important');
        loadMessages(studentId);
        clearInterval(chatInterval);
        chatInterval = setInterval(() => loadMessages(studentId), 5000);
    }

    // Load Messages
    function loadMessages(studentId = null) {
        let url = `/courses/${courseId}/messages`;
        if (studentId) url += `?student_id=${studentId}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.messages) {
                    renderMessages(data.messages);
                }
            });
    }

    function renderMessages(messages) {
        chatMessages.innerHTML = '';
        if (messages.length === 0) {
            chatMessages.innerHTML = '<div class="text-center text-muted small mt-5">No messages yet. Start the conversation!</div>';
            return;
        }

        messages.forEach(msg => {
            const isMe = msg.sender_id === authUserId;
            const bubbleClass = isMe ? 'bg-primary text-white ms-auto' : 'bg-white border me-auto';
            const alignment = isMe ? 'justify-content-end' : 'justify-content-start';
            
            const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

            const msgDiv = document.createElement('div');
            msgDiv.className = `d-flex mb-2 ${alignment}`;
            msgDiv.innerHTML = `
                <div class="rounded p-2 shadow-sm ${bubbleClass}" style="max-width: 80%; word-wrap: break-word;">
                    <div style="font-size: 0.9rem;">${msg.message_text}</div>
                    <div style="font-size: 0.65rem; opacity: 0.8; text-align: right;" class="mt-1">${time}</div>
                </div>
            `;
            chatMessages.appendChild(msgDiv);
        });
        
        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Send Message
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const text = chatInput.value.trim();
        if (!text) return;

        const payload = {
            message_text: text,
            _token: '{{ csrf_token() }}'
        };

        if (authUserRole === 'teacher') {
            payload.receiver_id = receiverInput.value;
        }

        fetch(`/courses/${courseId}/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                throw new Error(`HTTP ${res.status}: ${text.substring(0, 100)}...`);
            }
            return res.json();
        })
        .then(data => {
            if (data.message) {
                chatInput.value = '';
                loadMessages(authUserRole === 'teacher' ? receiverInput.value : null);
            } else if (data.error) {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('Failed to send message. Details: ' + error.message);
        });
    });
});
</script>
