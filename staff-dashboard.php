<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Staff Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="navbar">
        <div class="navbar-container">
            <a href="staff-dashboard.php" class="logo">MedInventory</a>
            <ul class="nav-links">
                <li><a href="staff-dashboard.php" class="active">Dashboard</a></li>
                <li><a href="medicine-inventory.php">Medicine Inventory</a></li>
                <li><a href="invoice.php">Generate Invoice</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="staff-dashboard">
        <div class="dashboard-staff-item">
            <a href="medicine-inventory.php"><img src="img/Inventory.png" alt="medicine-inventory"></a>
            <h2>View Medicines</h2>
            <button><a href="medicine-inventory.php">Go to Medicines</a></button>
        </div>
        <div class="dashboard-staff-item">
            <a href="invoice.php"><img src="img/invoice.png" alt="invoice"></a>
            <h2>Generate Invoice</h2>
            <button><a href="invoice.php">Generate Invoice</a></button>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
