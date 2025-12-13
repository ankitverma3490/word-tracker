<?php
// backend-php/config/cors.php

function handleCors()
{
    // Define allowed origins
    $allowed_origins = [
        'http://localhost:4200',
        'https://word-tracker-henna.vercel.app'
    ];

    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    // Check if origin is allowed
    if (in_array($origin, $allowed_origins)) {
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); // Cache for 1 day
    }

    // Handle Preflight Options
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (in_array($origin, $allowed_origins)) {
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        }
        exit(0);
    }
}
?>