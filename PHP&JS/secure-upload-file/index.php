

<?php

// Set response format to JSON

header("Content-Type: application/json");

$max_size = 5 * 1024 * 1024;
$allowed = [
    'jpg' => 'image/jpeg',
    'png' => 'image/png',
    'pdf' => 'application/pdf'
];

if (!isset($_FILES['uploaded_file'])) {
    http_response_code(400);
    echo json_encode(["error" => "No file uploaded"], JSON_PRETTY_PRINT);
    exit;
}

$file = $_FILES['uploaded_file'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(["error" => "Upload failed"], JSON_PRETTY_PRINT);
    exit;
}

if ($file['size'] > $max_size) {
    http_response_code(400);
    echo json_encode(["error" => "File is too large"], JSON_PRETTY_PRINT);
    exit;
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!isset($allowed[$ext])) {
    http_response_code(400);
    echo json_encode(["error" => "File type is not allowed"], JSON_PRETTY_PRINT);
    exit;
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
if ($mime !== $allowed[$ext]) {
    http_response_code(400);
    echo json_encode(["error" => "File content does not match its extension"], JSON_PRETTY_PRINT);
    exit;
}

$dir = dirname(__DIR__, 2) . '/private_uploads';
if (!is_dir($dir) && !mkdir($dir, 0700, true)) {
    http_response_code(500);
    echo json_encode(["error" => "Could not prepare storage"], JSON_PRETTY_PRINT);
    exit;
}

$name = bin2hex(random_bytes(16)) . '.' . $ext;
$path = $dir . '/' . $name;

if (!move_uploaded_file($file['tmp_name'], $path)) {
    http_response_code(500);
    echo json_encode(["error" => "Could not save file"], JSON_PRETTY_PRINT);
    exit;
}

chmod($path, 0600);
echo json_encode(["message" => "File uploaded", "name" => $name], JSON_PRETTY_PRINT);
?>
