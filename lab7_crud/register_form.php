<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .login-link a {
            color: #FF69B4; 
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register New User</h2>
        <form action="insert.php" method="post">
            
            <div class="form-group">
                <label for="matric">Matric:</label>
                <input type="text" name="matric" id="matric" required>
            </div>
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            
            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="">Please select</option>
                    <option value="lecturer">Lecturer</option>
                    <option value="student">Student</option>
                </select>
            </div>
            
            <input type="submit" name="submit" value="Register">
        </form>
        
        <p class="login-link">
            Already have an account? <a href="login.php">Login here.</a>
        </p>
    </div>
</body>
</html>