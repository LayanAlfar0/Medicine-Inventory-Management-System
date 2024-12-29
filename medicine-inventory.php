<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}include('backend/db.php');

$query = "SELECT * FROM medicines";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Management</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="navbar">
        <div class="navbar-container">
            <a href="staff-dashboard.php" class="logo">MedInventory</a>
            <ul class="nav-links">
                <li><a href="staff-dashboard.php">Dashboard</a></li>
                <li><a href="medicine-inventory.php" class="active">Medicine Inventory</a></li>
                <li><a href="invoice.php">Generate Invoice</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="medicine-inventory">
        <div class="top-div">
            <h2>Medicines</h2>
            <a href="staff-dashboard.php">Back to Dashboard</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Expiry Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['stock']; ?></td>
                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['expiry_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="js/script.js"></script>
</body>

</html>

<?php
$conn->close();
?>
