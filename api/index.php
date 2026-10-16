<?php

/**
 * Vercel Serverless Entrypoint for Laravel.
 * Forwards all incoming serverless requests to public/index.php.
 */
require __DIR__ . '/../public/index.php';
