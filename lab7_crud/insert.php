<?php
session_start();

include 'Database.php';
include 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $matric = isset($_POST['matric']) ? trim($_POST['matric']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    if ($matric === '' || $name === '' || $password === '' || $role === '') {
        $_SESSION['register_error'] = "Please fill all required fields.";
        header("Location: register.php");
        exit;
    } else {
        $result = $user->createUser($matric, $name, $password, $role);

        if ($result === true) {
            $_SESSION['login_message'] = "Registration successful! Please log in.";
            header("Location: login.php");
            exit;
        } else {
            $_SESSION['register_error'] = "Registration failed: " . $result;
            header("Location: register.php");
            exit;
        }
    }

} else {
    header("Location: register.php");
    exit;
}
?>
