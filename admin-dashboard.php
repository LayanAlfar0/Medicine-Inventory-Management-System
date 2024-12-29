<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin' ) {
    header('Location: login.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="navbar">
        <div class="navbar-container">
            <a href="index.html" class="logo">MedInventory</a>
            <ul class="nav-links">
                <li><a href="admin-dashboard.php" class="active">Dashboard</a></li>
                <li><a href="user-management.php">User Management</a></li>
                <li><a href="medicine-management.php">Medicine Management</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="admin-dashboard">
        <div class="dashboard-admin-item">
            <a href="user-management.php"><img src="img/pharmacy-staffing.png" alt="pharmacy-staffing"></a>
            <h2>Manage Users</h2>
            <button><a href="user-management.php">Go to User Management</a></button>
        </div>
        <div class="dashboard-admin-item">
            <a href="medicine-management.php"><img src="img/medicine.png" alt="medicine"></a>
            <h2>Manage Medicines</h2>
            <button><a href="medicine-management.php">Go to Medicine Management</a></button>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>
