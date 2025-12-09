<?php
session_start();
if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit;
}

// Ensure the central database and model instantiation file is included
include 'Database.php';
include 'User.php';

// The page is accessed via a GET request when the user clicks the "Update" link
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matric'])) {
    
    // 1. Retrieve and clean the matric value
    $matric_to_update = trim($_GET['matric']);

    if (empty($matric_to_update)) {
        header("Location: display_users.php");
        exit;
    }

$database = new Database();
$db = $database->getConnection();
$user_model = new User($db);

$userDetails = $user_model->getUser($matric_to_update);

    
    if (!$userDetails) {
        // User not found
        echo "Error: User with matric {$matric_to_update} not found.";
        exit;
    }
    
    // Variables are set. Proceed to display the form HTML.
    
} else {
    // Redirect if accessed directly without GET parameters
    header("Location: display_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: DarkKhaki; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); 
            width: 100%;
            max-width: 400px;
        }
         h2 {
            color: #6B8E23; 
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #C8E6C9; 
            border-radius: 8px;
            box-sizing: border-box; 
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #A5D6A7; 
            outline: none;
            box-shadow: 0 0 0 3px rgba(107, 142, 35, 0.2); /* Soft focus ring */
        }
        
        
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #6B8E23; 
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #557916;
        }


        
        input[type="text"], input[type="password"], select { 
            padding: 8px; border: 1px solid #A5D6A7; border-radius: 4px; 
            width: 250px; margin-bottom: 10px; box-sizing: border-box; 
        }

        .cancel-link { color: #FF69B4; text-decoration: none; margin-left: 15px; font-weight: bold; text-align:center; }
        .cancel-link:hover { text-decoration: underline; }
        
        .error-message { color: #C70039; font-weight: bold; margin-bottom: 15px; }
    </style>
</head>

<body><div class="container">
    <h2>Update User</h2>
    
    <?php
    // Display update error message if redirected from update_process.php
    // We assume update_process.php redirects back to this file on error: update_form.php?matric=...
    if (isset($_SESSION['update_error'])) {
        echo '<p class="error-message">' . htmlspecialchars($_SESSION['update_error']) . '</p>';
        unset($_SESSION['update_error']);
    }
    ?>

    <form action="update.php" method="post">
        
        <label for="matric_display">Matric:</label>
        <input type="text" id="matric_display" value="<?php echo htmlspecialchars($userDetails['matric']); ?>" readonly><br>
        <input type="hidden" name="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userDetails['name']); ?>" required><br>
        
        <label for="role">Access Level:</label>
        <select name="role" id="role" required>
            <option value="lecturer" <?php if ($userDetails['role'] == 'lecturer') echo "selected"; ?>>lecturer</option>
            <option value="student" <?php if ($userDetails['role'] == 'student') echo "selected"; ?>>student</option>
        </select><br>

        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" placeholder="Leave blank to keep current"><br>
        
        <input type="submit" name="submit" value="Update"><br>
        <a href="read.php" class="cancel-link">Cancel</a>
    </form>
</div>

</body>
</html>