<?php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');

if ($uri === '/index.php' || str_starts_with($uri, '/index.php/')) {
    $target = substr($uri, strlen('/index.php')) ?: '/';
    $query = $_SERVER['QUERY_STRING'] ?? '';

    header('Location: '.$target.($query ? '?'.$query : ''), true, 301);

    return true;
}

if ($uri !== '/' && file_exists(__DIR__.$uri)) {
    return false;
}

require_once __DIR__.'/index.php';
