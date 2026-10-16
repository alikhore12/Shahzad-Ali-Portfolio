<?php

/**
 * Vercel Serverless Bootstrapper for Laravel
 * Handles read-only Lambda environment by preparing writable /tmp directories.
 */

putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
} else {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
}

putenv('LARAVEL_STORAGE_PATH=/tmp/storage');
$_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

// 1. Prepare writable /tmp storage paths
$tmpDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
    '/tmp/bootstrap/cache',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 2. Redirect Laravel storage and view cache to /tmp
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

// Copy bootstrap cache manifests to writable /tmp
$sourcePackages = __DIR__ . '/../bootstrap/cache/packages.php';
$targetPackages = '/tmp/bootstrap/cache/packages.php';
if (file_exists($sourcePackages)) {
    $packages = @require $sourcePackages;
    if (is_array($packages)) {
        foreach ($packages as $pkg => $cfg) {
            if (isset($cfg['providers'])) {
                $packages[$pkg]['providers'] = array_values(array_filter($cfg['providers'], fn($p) => class_exists($p)));
            }
        }
        @file_put_contents($targetPackages, '<?php return ' . var_export($packages, true) . ';');
    }
}
putenv("APP_PACKAGES_CACHE={$targetPackages}");
$_ENV['APP_PACKAGES_CACHE'] = $targetPackages;
$_SERVER['APP_PACKAGES_CACHE'] = $targetPackages;

$sourceServices = __DIR__ . '/../bootstrap/cache/services.php';
$targetServices = '/tmp/bootstrap/cache/services.php';
if (file_exists($sourceServices)) {
    $services = @require $sourceServices;
    if (is_array($services)) {
        if (isset($services['providers'])) {
            $services['providers'] = array_values(array_filter($services['providers'], fn($p) => class_exists($p)));
        }
        if (isset($services['eager'])) {
            $services['eager'] = array_values(array_filter($services['eager'], fn($p) => class_exists($p)));
        }
        if (isset($services['deferred'])) {
            $services['deferred'] = array_filter($services['deferred'], fn($p) => class_exists($p));
        }
        if (isset($services['when'])) {
            $services['when'] = array_filter($services['when'], fn($p) => class_exists($p));
        }
        @file_put_contents($targetServices, '<?php return ' . var_export($services, true) . ';');
    }
}
putenv("APP_SERVICES_CACHE={$targetServices}");
$_ENV['APP_SERVICES_CACHE'] = $targetServices;
$_SERVER['APP_SERVICES_CACHE'] = $targetServices;

// Ensure session & cache do not try to write to read-only DB/filesystem
putenv('SESSION_DRIVER=cookie');
$_ENV['SESSION_DRIVER'] = 'cookie';
$_SERVER['SESSION_DRIVER'] = 'cookie';

putenv('CACHE_STORE=array');
$_ENV['CACHE_STORE'] = 'array';
$_SERVER['CACHE_STORE'] = 'array';

putenv('APP_DEBUG=true');
$_ENV['APP_DEBUG'] = 'true';
$_SERVER['APP_DEBUG'] = 'true';

// 3. Fallback for APP_KEY
if (!getenv('APP_KEY')) {
    $fallbackKey = 'base64:J1b4f1dPBV9pkfrTg+r8agD7a1dmiRSvRt1adO0BR2s=';
    putenv("APP_KEY={$fallbackKey}");
    $_ENV['APP_KEY'] = $fallbackKey;
    $_SERVER['APP_KEY'] = $fallbackKey;
}

// 4. Handle SQLite database in writable /tmp
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';

if (!file_exists($targetDb) || filesize($targetDb) === 0) {
    if (file_exists($sourceDb) && filesize($sourceDb) > 0) {
        @copy($sourceDb, $targetDb);
    } else {
        @touch($targetDb);
    }
}

if (file_exists($targetDb)) {
    putenv("DB_DATABASE={$targetDb}");
    $_ENV['DB_DATABASE'] = $targetDb;
    $_SERVER['DB_DATABASE'] = $targetDb;
    putenv('DB_CONNECTION=sqlite');
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_SERVER['DB_CONNECTION'] = 'sqlite';
}

// 5. Run Laravel application
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo '<!DOCTYPE html><html><head><title>Application Error</title><style>body{font-family:sans-serif;background:#09090b;color:#f4f4f5;padding:2rem;line-height:1.6}h1{color:#ef4444}pre{background:#18181b;padding:1rem;border-radius:8px;overflow:auto}</style></head><body>';
    echo '<h1>Laravel Deployment Error</h1>';
    echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . '</p>';
    echo '<h3>Stack Trace:</h3>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '</body></html>';
}
