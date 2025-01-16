<?php
$data_file = 'data.json';

// Get the requested URI
$request_uri = $_SERVER['REQUEST_URI'];

// Check if the URI starts with "/url/"
if (strpos($request_uri, '/url/') === 0) {
    // Extract the alias from the URI
    $alias = substr($request_uri, strlen('/url/'));

    // Load existing data
    $data = json_decode(file_get_contents($data_file), true);

    // Check if the alias exists
    if (isset($data[$alias])) {
        // Redirect to the original URL
        header('Location: ' . $data[$alias]);
        exit;
    } else {
        // Alias not found, show 404 error
        http_response_code(404);
        echo '<h1>404: URL Not Found</h1>';
        exit;
    }
}

// For any other request, show an error or redirect to a default page
echo '<h1>Invalid Request</h1>';
