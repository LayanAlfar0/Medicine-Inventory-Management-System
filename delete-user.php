<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin' ) {
    header('Location: login.php'); 
    exit();
}
include('backend/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the user
    $query = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: user-management.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
