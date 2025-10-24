<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Simples autenticação (em produção, use algo mais seguro)
$auth_token = $_POST['auth_token'] ?? '';
if ($auth_token !== 'starpools_admin_2024') {
    http_response_code(401);
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
    exit;
}

// Salvar alterações em arquivo
$changes_file = 'site-changes.json';
file_put_contents($changes_file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Aplicar alterações ao site (em produção, isso seria mais sofisticado)
applyChangesToSite($data);

echo json_encode(['success' => true, 'message' => 'Alterações salvas com sucesso']);

function applyChangesToSite($data) {
    $site_file = '../index.html';
    
    if (!file_exists($site_file)) {
        return;
    }
    
    $content = file_get_contents($site_file);
    
    // Aplicar alterações de texto
    if (isset($data['text_changes'])) {
        foreach ($data['text_changes'] as $selector => $new_content) {
            // Buscar e substituir conteúdo baseado no seletor
            $pattern = getPatternFromSelector($selector, $new_content);
            if ($pattern) {
                $content = preg_replace($pattern, '$1' . addcslashes($new_content, '$\\') . '$2', $content);
            }
        }
    }
    
    // Aplicar alterações de imagens
    if (isset($data['image_changes'])) {
        foreach ($data['image_changes'] as $selector => $new_src) {
            $pattern = '/(' . preg_quote($selector, '/') . '.*?src=")[^"]*(")/i';
            $content = preg_replace($pattern, '$1' . $new_src . '$2', $content);
        }
    }
    
    file_put_contents($site_file, $content);
}

function getPatternFromSelector($selector, $content) {
    // Simplificado - em produção, use uma biblioteca de parsing HTML
    if (strpos($selector, '.') === 0) {
        // Seletor de classe
        $class = substr($selector, 1);
        return '/<(?:div|p|span|h[1-6])[^>]*class="[^"]*' . $class . '[^"]*"[^>]*>(.*?)<\/[^>]+>/is';
    } elseif (strpos($selector, '#') === 0) {
        // Seletor de ID
        $id = substr($selector, 1);
        return '/<[^>]*id="' . $id . '"[^>]*>(.*?)<\/[^>]+>/is';
    }
    
    return null;
}
?>
