<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$changes_file = 'site-changes.json';
if (file_exists($changes_file)) {
    $changes = json_decode(file_get_contents($changes_file), true);
    echo json_encode($changes ?: []);
} else {
    echo json_encode([]);
}
?>
