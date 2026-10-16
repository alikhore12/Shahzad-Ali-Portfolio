<?php

/**
 * Vercel Serverless Bootstrapper for Laravel
 * Handles read-only Lambda environment by preparing writable /tmp directories.
 */

// 1. Prepare writable /tmp storage paths for compiled views, cache, sessions & logs
$tmpDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Redirect Laravel cache and view paths to /tmp
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

putenv('APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php');
putenv('APP_EVENTS_CACHE=/tmp/bootstrap/cache/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');

// 3. Fallback for APP_KEY if not configured in Vercel UI
if (!getenv('APP_KEY')) {
    $fallbackKey = 'base64:J1b4f1dPBV9pkfrTg+r8agD7a1dmiRSvRt1adO0BR2s=';
    putenv("APP_KEY={$fallbackKey}");
    $_ENV['APP_KEY'] = $fallbackKey;
    $_SERVER['APP_KEY'] = $fallbackKey;
}

// 4. Handle SQLite database in writable /tmp
if (!file_exists('/tmp/database.sqlite')) {
    $sourceDb = __DIR__ . '/../database/database.sqlite';
    if (file_exists($sourceDb)) {
        @copy($sourceDb, '/tmp/database.sqlite');
    } else {
        @touch('/tmp/database.sqlite');
    }
}
if (file_exists('/tmp/database.sqlite')) {
    putenv('DB_DATABASE=/tmp/database.sqlite');
    $_ENV['DB_DATABASE'] = '/tmp/database.sqlite';
    $_SERVER['DB_DATABASE'] = '/tmp/database.sqlite';
}

// 5. Run Laravel application with error handling
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo '<!DOCTYPE html><html><head><title>Application Error</title><style>body{font-family:sans-serif;background:#09090b;color:#f4f4f5;padding:2rem;line-height:1.6}h1{color:#ef4444}pre{background:#18181b;padding:1rem;border-radius:8px;overflow:auto}</style></head><body>';
    echo '<h1>Laravel Deployment Notice</h1>';
    echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . '</p>';
    echo '<h3>Stack Trace:</h3>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '</body></html>';
}
