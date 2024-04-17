
<?php
/*
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the JSON data sent from the frontend
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if 'text' data exists in the JSON payload
    if (isset($data['text'])) {
        // Process the received text (e.g., perform database operations, log the text, etc.)
        $processedText = processText($data['text']);

        // Send the processed text back to the frontend
        echo $processedText;
    } else {
        // If 'text' data is missing, return an error response
        http_response_code(400);
        echo "Error: 'text' data not found in the request.";
    }
} else {
    // If the request method is not POST, return an error response
    http_response_code(405);
    echo "Error: Only POST requests are allowed.";
}

// Function to process the received text
function processText($text) {
    // Example: Convert the text to uppercase
    $processedText = strtoupper($text);

    // You can perform other processing tasks here based on your requirements

    return $processedText;
}*/


// Database configuration
$servername = "localhost"; // Change this to your database server
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "speech_recognition_db"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the JSON data sent from the frontend
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if 'text' data exists in the JSON payload
    if (isset($data['text'])) {
        // Process the received text
        $processedText = processText($data['text']);

        // Save the processed text to the database
        saveToDatabase($processedText, $conn);

        // Send a success response
        echo "Text saved successfully!";
    } else {
        // If 'text' data is missing, return an error response
        http_response_code(400);
        echo "Error: 'text' data not found in the request.";
    }
} else {
    // If the request method is not POST, return an error response
    http_response_code(405);
    echo "Error: Only POST requests are allowed.";
}

// Function to process the received text
function processText($text) {
    // Example: Convert the text to uppercase
    return strtoupper($text);
}

// Function to save the text to the database
function saveToDatabase($text, $conn) {
    $sql = "INSERT INTO texts (text) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $text);
    $stmt->execute();
    $stmt->close();
}

// Close the database connection
$conn->close();


?>
