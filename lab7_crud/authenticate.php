<?php
session_start();
if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit;
}

include 'Database.php';
include 'User.php';

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $matric = $db->real_escape_string($_POST['matric']);
    $password = $db->real_escape_string($_POST['password']);

    if (!empty($matric) && !empty($password)) {
        $user = new User($db);
        $userDetails = $user->getUser($matric);

        if ($userDetails && password_verify($password, $userDetails['password'])) {
            // Set session and redirect to read.php (CRUD page)
            $_SESSION['matric'] = $userDetails['matric'];
            $_SESSION['name'] = $userDetails['name'];
            $_SESSION['role'] = $userDetails['role'];
            header("Location: read.php");
            exit;
        } else {
            echo 'Login Failed. <a href="login.php">Go back</a>';
        }
    } else {
        echo 'Please fill in all required fields. <a href="login.php">Go back</a>';
    }

    $db->close();
} else {
    header("Location: login.php");
    exit;
}