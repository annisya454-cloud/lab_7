<?php

session_start();
if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit;
}


include 'Database.php';
include 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Initialize database and model
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    // Note: We don't close $db here because $user needs it for createUser.
    // The connection will close automatically when the script finishes.

    // 2. Retrieve and clean inputs
    $matric = isset($_POST['matric']) ? trim($_POST['matric']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : ''; // Do not trim password
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    // 3. Basic validation: Check if any required field is empty
    if ($matric === '' || $name === '' || $password === '' || $role === '') {
        
        // Set an error message in the session
        $_SESSION['register_error'] = "Please fill all required fields.";
        
        // Redirect back to the registration form (assuming it's named register.php)
        header("Location: register.php"); 
        exit;
        
    } else {
        // 4. Attempt to create user
        $result = $user->createUser($matric, $name, $password, $role);
        
        if ($result === true) {
            // Success: Set a message and redirect to the login page
            $_SESSION['login_message'] = "Registration successful! Please log in.";
            header("Location: login.php");
            exit;
        } else {
            // Failure: Set the detailed error message (e.g., duplicate matric)
            $_SESSION['register_error'] = "Registration failed: " . $result;
            
            // Redirect back to the registration form
            header("Location: register.php"); 
            exit;
        }
    }

} else {
    // If accessed via GET method, redirect to the form
    header("Location: register.php");
    exit;
}
?>