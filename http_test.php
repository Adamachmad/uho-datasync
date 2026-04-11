#!/usr/bin/env php
<?php
/**
 * UHO-Datasync HTTP Endpoint Tester
 */

echo "\n=== UHO-DATASYNC HTTP ENDPOINT TEST ===\n\n";

echo "Starting server on port 8000...\n";
$serverProc = proc_open(
    'php artisan serve --host=127.0.0.1 --port=8000',
    [ 
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w']
    ],
    $pipes,
    getcwd()
);

sleep(3); // Wait for server to start

echo "Server started. Testing endpoints...\n\n";

// Test endpoints
$endpoints = [
    'GET' => [
        '/' => 'Homepage',
        '/login' => 'Login page',
        '/daftar' => 'Registration page',
    ]
];

foreach ($endpoints['GET'] as $path => $desc) {
    echo "Testing: GET $path ($desc)\n";
    try {
        $context = stream_context_create(['http' => ['timeout' => 5]]);
        $response = @file_get_contents("http://127.0.0.1:8000$path", false, $context);
        if ($response === false) {
            echo "  ✗ Failed to connect\n";
        } else {
            echo "  ✓ Response received (" . strlen($response) . " bytes)\n";
        }
    } catch (Exception $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
}

echo "\nTerminating server...\n";
proc_terminate($serverProc);
fclose($pipes[1]);
fclose($pipes[2]);

echo "Test complete.\n";
