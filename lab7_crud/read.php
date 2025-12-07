<?php
session_start();
if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit;
}

include 'Database.php';
include 'User.php';

// Create an instance of the Database class and get the connection
$database = new Database();
$db = $database->getConnection();

// Create an instance of the User class
$user = new User($db);
$result = $user->getUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read</title>
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
        table, th, td {
  border: 1px solid green;}
    .update-link {
            text-align: center;
            font-size: 0.9em;
        }

        .update-link a {
            color: #FF69B4; 
            text-decoration: none;
            font-weight: 600;
        }
        .update-link a:hover {
            text-decoration: underline;
        }
          .delete-link {
            text-align: center;
            font-size: 0.9em;
        }

        .delete-link a {
            color: #FF69B4; 
            text-decoration: none;
            font-weight: 600;
        }
        .delete-link a:hover {
            text-decoration: underline;
        }
</style>
</head>

<body><div class="container">
    <h2>List of User</h2>
    <table border="1">
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Fetch each row from the result set
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row["matric"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["role"]; ?></td>
                    <td><p class="update-link"><a href="update_form.php?matric=<?php echo $row["matric"]; ?>">Update</a></p></td>
                    <td><p class="delete-link"><a href="delete.php?matric=<?php echo $row["matric"]; ?>">Delete</a></p></td>

                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
        }
        // Close connection
        $db->close();
        ?>
    </table>
    </div>
</body>

</html>