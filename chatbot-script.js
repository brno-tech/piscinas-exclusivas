// Chatbot Functions
function openN8nChat() {
    const chatbot = document.getElementById('chatbotContainer');
    chatbot.classList.add('active');
}

function closeChatbot() {
    const chatbot = document.getElementById('chatbotContainer');
    chatbot.classList.remove('active');
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    const closeBtn = document.getElementById('closeChatbot');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeChatbot);
    }
    
    // Fechar ao pressionar ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeChatbot();
        }
    });
    
    // Fechar ao clicar fora (opcional)
    document.addEventListener('click', (e) => {
        const chatbot = document.getElementById('chatbotContainer');
        const chatbotBtns = document.querySelectorAll('[onclick*="openN8nChat"]');
        
        let clickedButton = false;
        chatbotBtns.forEach(btn => {
            if (btn.contains(e.target)) clickedButton = true;
        });
        
        if (chatbot && chatbot.classList.contains('active') && 
            !chatbot.contains(e.target) && !clickedButton) {
            closeChatbot();
        }
    });
});
