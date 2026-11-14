
<?php

// Set response format to JSON

header("Content-Type: application/json");

// Get request method

$method = $_SERVER['REQUEST_METHOD'];

// Get request headers

$headers = getallheaders();

// Read JSON data from request body

$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Check JSON validity for methods that need a body

if (in_array($method, ["POST", "PUT"]) && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);

    $response = [
        "status" => "error",
        "message" => "Invalid JSON data"
    ];

} else {

    // Handle HTTP requests

    switch ($method) {

        case "GET":
            http_response_code(200);

            $response = [
                "status" => "success",
                "message" => "GET request received successfully"
            ];
            break;

        case "POST":
            http_response_code(201);

            $response = [
                "status" => "success",
                "message" => "Data received successfully",
                "data" => $data
            ];
            break;

        case "PUT":
            http_response_code(200);

            $response = [
                "status" => "success",
                "message" => "Data updated successfully",
                "data" => $data
            ];
            break;

        case "DELETE":
            http_response_code(200);

            $response = [
                "status" => "success",
                "message" => "DELETE request received successfully"
            ];
            break;

        default:
            http_response_code(405);

            $response = [
                "status" => "error",
                "message" => "Method Not Allowed"
            ];
            break;
    }
}

// Check Authorization header

if (isset($headers['Authorization'])) {
    $response["authorization"] = "Authorization header received";
}

// Print JSON response

echo json_encode($response, JSON_PRETTY_PRINT);

?>
