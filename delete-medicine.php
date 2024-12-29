<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin' ) {
    header('Location: login.php'); 
    exit();
}
include('backend/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete_query = "DELETE FROM medicines WHERE id = '$id'";

    if (mysqli_query($conn, $delete_query)) {
        echo "Medicine deleted successfully!";
        header("Location: medicine-management.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "No ID provided.";
    exit;
}
mysqli_close($conn);
?>
