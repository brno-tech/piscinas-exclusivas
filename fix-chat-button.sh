#!/bin/bash

# Substituir a função openN8nChat por uma que funciona
sed -i '/function openN8nChat/,/^}/d' index.html

# Adicionar nova função antes do </body>
sed -i '/<\/body>/i\
<script>\
function openN8nChat() {\
  // Rolar até o final da página onde o chat está\
  window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });\
  \
  // Aguardar 1 segundo e tentar abrir o chat\
  setTimeout(() => {\
    // Procurar o iframe do n8n\
    const iframe = document.querySelector("iframe");\
    if (iframe) {\
      // Simular hover/click no iframe para ativar o chat\
      iframe.style.pointerEvents = "auto";\
      const evt = new MouseEvent("click", { bubbles: true, cancelable: true });\
      iframe.dispatchEvent(evt);\
    }\
    \
    // Mostrar notificação visual\
    const notify = document.createElement("div");\
    notify.textContent = "💬 Chat aberto no final da página!";\
    notify.style.cssText = "position:fixed;top:20px;right:20px;background:#2563eb;color:white;padding:15px 25px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.3);z-index:10000;font-family:sans-serif;";\
    document.body.appendChild(notify);\
    setTimeout(() => notify.remove(), 3000);\
  }, 1000);\
}\
</script>' index.html

echo "✅ Função do chat corrigida!"
