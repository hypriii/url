<?php
header('Content-Type: application/json');

$data_file = 'data.json';

// Load existing data
$data = json_decode(file_get_contents($data_file), true);

// Get input from frontend
$input = json_decode(file_get_contents('php://input'), true);
$url = trim($input['url']);
$alias = trim($input['alias']);

// Validate URL
if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
    echo json_encode(['error' => 'Invalid URL.']);
    exit;
}

// Generate random alias if none is provided
if (empty($alias)) {
    $alias = substr(md5(uniqid()), 0, 6); // Random 6-character alias
}

// Check for alias conflicts
if (isset($data[$alias])) {
    echo json_encode(['error' => 'Alias already taken. Please choose another.']);
    exit;
}

// Save the alias and URL
$data[$alias] = $url;
file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));

// Return the shortened URL
$short_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . "/url/" . $alias;
echo json_encode(['short_url' => $short_url]);
