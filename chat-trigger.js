function openN8nChat() {
  // Tentar encontrar o botão do chat n8n de várias formas
  const selectors = [
    'button[data-key]',
    '[role="button"]',
    'button',
    'div[role="button"]'
  ];
  
  // Procurar dentro do shadow DOM ou iframe
  const iframe = document.querySelector('iframe');
  if (iframe && iframe.contentWindow) {
    try {
      const iframeDoc = iframe.contentWindow.document;
      for (const selector of selectors) {
        const btn = iframeDoc.querySelector(selector);
        if (btn && btn.offsetParent !== null) {
          btn.click();
          return true;
        }
      }
    } catch(e) {
      console.log('Não conseguiu acessar iframe:', e);
    }
  }
  
  // Procurar no documento principal
  for (const selector of selectors) {
    const elements = document.querySelectorAll(selector);
    for (const el of elements) {
      if (el.textContent.includes('💬') || el.innerHTML.includes('chat')) {
        el.click();
        return true;
      }
    }
  }
  
  // Se não encontrou, esperar o chat carregar
  setTimeout(() => {
    const chatWidget = document.querySelector('[class*="chat"]');
    if (chatWidget) chatWidget.click();
  }, 500);
  
  return false;
}
