#!/bin/bash

# Adicionar tag <main> ao redor do conteúdo principal
sed -i 's/<body>/<body>\n<main role="main">/' index.html
sed -i 's/<\/body>/<\/main>\n<\/body>/' index.html

# Adicionar aria-label nos botões de WhatsApp/ligação
sed -i 's/href="https:\/\/wa.me/aria-label="Falar no WhatsApp" href="https:\/\/wa.me/g' index.html
sed -i 's/href="tel:/aria-label="Ligar agora" href="tel:/g' index.html

# Melhorar contraste - mudar cores muito claras para mais escuras
# (vamos fazer ajustes específicos depois de ver o código)

echo "Correções aplicadas!"
