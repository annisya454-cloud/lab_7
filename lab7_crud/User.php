<?php
class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // --- C: Create a new user ---
    public function createUser($matric, $name, $password, $role)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $matric, $name, $password, $role);
            $result = $stmt->execute();
            $stmt->close();
            
            if ($result) {
                return true;
            } else {
                return "Error: " . $this->conn->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // --- R: Read all users ---
    public function getUsers()
    {
        $sql = "SELECT matric, name, role FROM users ORDER BY matric ASC";
        $result = $this->conn->query($sql);
        return $result;
    }

    // --- R: Read a single user by matric (Used for Login & Update Forms) ---
    public function getUser($matric)
    {
        $sql = "SELECT * FROM users WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $matric);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // --- U: Update a user's name and role (NON-PASSWORD fields) ---
    public function updateUser($matric, $name, $role)
    {
        $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $name, $role, $matric);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                return true;
            } else {
                return "Error: " . $this->conn->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }
    
    // --- U: Update a user's password (SENSITIVE field) ---
    public function updateUserPassword($matric, $new_password)
    {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $hashed_password, $matric);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // --- D: Delete a user by matric ---
    public function deleteUser($matric)
    {
        $sql = "DELETE FROM users WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $matric);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                return true;
            } else {
                return "Error: " . $this->conn->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }
}
?>