<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://cdn-icons-png.freepik.com/256/3178/3178285.png?ga=GA1.1.2125020956.1709586637&" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet"> <!-- You can define your CSS styles in this file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 350px;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #ff3333;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="username">Username :</label>
                <input type="username" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <?php if (isset($_GET['error'])) : ?>
                <p class="error-message">Invalid Username or password. Please try again.</p>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>



<?php
// Start the session to store user information
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "student/partities/connection.php";

    // Retrieve user input
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare and execute a statement to fetch user details from the database
    $stmt = $connection->prepare("SELECT * FROM user WHERE user_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    

    // Check if a user with the provided username exists
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        echo "Password entered: " . $password . "<br>";
        echo "Password from database: " . $user["password"] . "<br>";
        
        
        // Verify password
        if ($password == $user["password"]) {
            // Store user information in session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_username"] = $user["username"];
            $_SESSION["user_role"] = $user["role"];

            // Redirect to the appropriate dashboard based on user role
            if ($user["role"] == "Student") {
                header("Location: student/StudentHome.php");
                exit();
            } elseif ($user["role"] == "Instructor") {
                header("Location: ınstructor/InstructorHome.php");
                exit();
            }
        } else {
            // Password is incorrect
            header("Location:login.php?error=incorrect_password");
            exit();
        }
    } else {
        // User with provided username not found
        header("Location: login.php?error=user_not_found");
        exit();
    }
} elseif (isset($_SESSION["user_id"])) {
    // User is already logged in, redirect to the appropriate dashboard
    if ($_SESSION["user_role"] == "Student") {
        header("Location: online_exam/student/StudentHome.php");
        exit();
    } elseif ($_SESSION["user_role"] == "Instructor") {
        header("Location: online_exam/instructor/InstructorHome.php");
        exit();
    }
}
?>
