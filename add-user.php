<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin' ) {
    header('Location: login.php'); 
    exit();
}
include('backend/db.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    
    // Handle file upload
    if (isset($_FILES['profile_pic'])) {
        $fileName = $_FILES['profile_pic']['name'];
        $fileTmpName = $_FILES['profile_pic']['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png'];
        
        if (in_array($fileExtension, $allowed)) {
            $newFileName = uniqid() . "." . $fileExtension;
            $fileDestination = 'img/' . $newFileName;
            move_uploaded_file($fileTmpName, $fileDestination);
        }
    }

    // Insert new user into the database
    $query = "INSERT INTO users (name, role, password, profile_pic) VALUES ('$name', '$role', '$password', '$newFileName')";
    if (mysqli_query($conn, $query)) {
        header('Location: user-management.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>
