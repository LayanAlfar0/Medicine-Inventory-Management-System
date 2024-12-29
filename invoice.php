<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}
include 'backend/db.php';

$query = "SELECT * FROM medicines";
$result = $conn->query($query);

$medicine = '';
$quantity = 0;
$totalPrice = 0;

//calculate the total price
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicine = $_POST['medicine'];
    $quantity = $_POST['quantity'];

    $medicineQuery = "SELECT price FROM medicines WHERE name = '$medicine'";
    $medicineResult = $conn->query($medicineQuery);
    
    if ($medicineResult->num_rows > 0) {
        $medicineData = $medicineResult->fetch_assoc();
        $price = $medicineData['price'];
        $totalPrice = $price * $quantity;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Invoice</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="navbar">
        <div class="navbar-container">
            <a href="staff-dashboard.php" class="logo">MedInventory</a>
            <ul class="nav-links">
                <li><a href="staff-dashboard.php">Dashboard</a></li>
                <li><a href="medicine-inventory.php">Medicine Inventory</a></li>
                <li><a href="invoice.php" class="active">Generate Invoice</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="invoice">
        <h2 class="center">Generate Invoice</h2>
        <form method="POST" action="invoice.php">
            <label>Medicine:</label>
            <select name="medicine" required>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?php echo $row['name']; ?>" <?php echo ($medicine == $row['name']) ? 'selected' : ''; ?>>
                        <?php echo $row['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?php echo $quantity; ?>" required>
            
            <label>Total Price:</label>
            <input type="text" value="$<?php echo number_format($totalPrice, 2); ?>" disabled>
            
            <button type="submit">Generate Invoice</button>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
