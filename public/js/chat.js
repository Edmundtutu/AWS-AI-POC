document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');
    const typingIndicator = document.getElementById('typingIndicator');

    // Configure marked options
    marked.setOptions({
        breaks: true,
        gfm: true,
        highlight: function (code, lang) {
            if (lang && hljs.getLanguage(lang)) {
                return hljs.highlight(code, { language: lang }).value;
            }
            return hljs.highlightAuto(code).value;
        }
    });

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message) return;

        // Add user message
        addMessage(message, 'user');
        messageInput.value = '';

        // Show typing indicator
        typingIndicator.style.display = 'block';
        chatMessages.scrollTop = chatMessages.scrollHeight;

        try {
            // Send message to server
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            
            // Hide typing indicator after a brief delay
            setTimeout(() => {
                typingIndicator.style.display = 'none';
                // Add bot response with markdown parsing
                addMessage(data.response, 'bot', true);
            }, 1000);

        } catch (error) {
            console.error('Error:', error);
            typingIndicator.style.display = 'none';
            addMessage('Sorry, something went wrong. Please try again.', 'bot');
        }
    });

    function addMessage(message, type, isMarkdown = false) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', `message-${type}`);
        
        if (isMarkdown && type === 'bot') {
            // Parse markdown and set innerHTML for bot messages
            messageDiv.innerHTML = marked.parse(message);
            // Initialize syntax highlighting for code blocks
            messageDiv.querySelectorAll('pre code').forEach((block) => {
                hljs.highlightBlock(block);
            });
        } else {
            // Regular text for user messages
            messageDiv.textContent = message;
        }
        
        // Insert before typing indicator
        chatMessages.insertBefore(messageDiv, typingIndicator);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}); 