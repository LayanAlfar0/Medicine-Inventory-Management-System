<?php
session_start();
include('backend/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];  
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE name = '$name'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            // Redirect based on role
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin-dashboard.php");
                exit();
            } elseif ($_SESSION['role'] == 'staff') {
                header("Location: staff-dashboard.php");
                exit();
            } else {
                $error_message = "Invalid role!";
            }
        } else {
            $error_message = "Incorrect password";
        }
    } else {
        $error_message = "User not found";
    }
    $result->free();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="navbar" style="margin-bottom: 0;">
        <div class="navbar-container">
            <a href="index.html" class="logo">MedInventory</a>
            <ul class="nav-links">
                <li><a href="index.html" >Home</a></li>
                <li><a href="login.php" class="active">Login</a></li>
            </ul>
        </div>
    </div>
    <div class="login-container">
        <form method="POST" style="margin-top: 9rem;background:#9bdccf;">
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <?php
        if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>
