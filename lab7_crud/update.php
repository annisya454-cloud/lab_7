<?php
session_start();

// ✅ Login check
if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit;
}

include 'Database.php';
include 'User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

/* =========================
   ✅ HANDLE UPDATE (POST)
   ========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matric = $_POST['matric'];
    $name   = $_POST['name'];
    $role   = $_POST['role'];
    $password = $_POST['password'];

    // ✅ Update name & role
    $updateResult = $user->updateUser($matric, $name, $role);

    if ($updateResult !== true) {
        echo "Update failed: " . $updateResult;
        exit;
    }

    // ✅ Update password ONLY if user typed one
    if (!empty($password)) {
        $user->updateUserPassword($matric, $password);
    }

    // ✅ Redirect after successful update
    header("Location: read.php");
    exit;
}

/* =========================
   ✅ FETCH USER (GET)
   ========================= */
if (!isset($_GET['matric']) || empty($_GET['matric'])) {
    header("Location: read.php");
    exit;
}

$matric_to_update = $_GET['matric'];
$userDetails = $user->getUser($matric_to_update);

if (!$userDetails) {
    echo "User not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
</head>

<body>
    <h2>Update User</h2>

    <form action="update.php" method="post">

        <input type="hidden" name="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>">

        <label>Matric (Read Only)</label>
        <input type="text" value="<?php echo htmlspecialchars($userDetails['matric']); ?>" readonly><br><br>

        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($userDetails['name']); ?>" required><br><br>

        <label>Role</label>
        <select name="role" required>
            <option value="lecturer" <?php if ($userDetails['role'] == 'lecturer') echo "selected"; ?>>Lecturer</option>
            <option value="student" <?php if ($userDetails['role'] == 'student') echo "selected"; ?>>Student</option>
        </select><br><br>

        <label>New Password (Leave blank to keep current)</label>
        <input type="password" name="password"><br><br>

        <input type="submit" value="Update">
        <a href="read.php">Cancel</a>

    </form>
</body>
</html>
