<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_reservation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate the name
function validateName($name) {
    return preg_match("/^[a-zA-Z\s]+$/", $name);
}

// Function to validate the phone number
function validatePhoneNumber($phone) {
    return preg_match("/^\d{10}$/", $phone);
}

// Function to validate the email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Get form data from the GET request
$name = $_GET['name'];
$phone = $_GET['phone'];
$email = $_GET['email'];

// Validate form data
if (validateName($name) && validatePhoneNumber($phone) && validateEmail($email)) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO reservations (name, phone, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $phone, $email);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Form data is invalid!";
}

// Close connection
$conn->close();
?>
