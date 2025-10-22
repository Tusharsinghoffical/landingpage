<?php
// Simple health check endpoint for Render
header('Content-Type: application/json');
echo json_encode([
    'status' => 'healthy',
    'timestamp' => date('c'),
    'service' => 'Packers & Movers Website'
]);