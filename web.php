<?php
// This file is used by Render to serve the application
// It's a simple router that includes the appropriate PHP file based on the request URI

// For Docker with Apache, this file might not be needed as Apache will handle routing
// But we'll keep it for compatibility

// Get the request URI and remove query string
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove leading slash
$uri = ltrim($uri, '/');

// If URI is empty, serve index.php
if ($uri === '') {
    require 'index.php';
    exit;
}

// Define valid pages
$validPages = [
    'about' => 'about.php',
    'services' => 'services.php',
    'inquiry' => 'inquiry.php',
    'admin' => 'admin.php',
    'privacy' => 'privacy.php',
    'terms' => 'terms.php',
    'sitemap' => 'sitemap.php',
    'install' => 'install.php',
    'health-check' => 'health-check.php',
    'deploy' => 'deploy.php',
    'healthz' => 'healthz.php'
];

// Check if the URI matches a valid page
if (array_key_exists($uri, $validPages)) {
    require $validPages[$uri];
    exit;
}

// Check if it's a direct file access (like assets)
if (file_exists($uri) && is_file($uri)) {
    // Serve static files directly
    $extension = pathinfo($uri, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon'
    ];
    
    if (isset($mimeTypes[$extension])) {
        header('Content-Type: ' . $mimeTypes[$extension]);
    }
    
    readfile($uri);
    exit;
}

// If nothing matches, serve 404 page
http_response_code(404);
require '404.php';