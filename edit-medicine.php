<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin' ) {
    header('Location: login.php'); 
    exit();
}
include('backend/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM medicines WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $medicine = mysqli_fetch_assoc($result);

    if (!$medicine) {
        echo "Medicine not found!";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $expiry_date = $_POST['expiry_date'];

        $update_query = "UPDATE medicines SET 
                            name = '$name', 
                            category = '$category', 
                            price = '$price', 
                            stock = '$stock', 
                            expiry_date = '$expiry_date'
                            WHERE id = '$id'";

        if (mysqli_query($conn, $update_query)) {
            echo "Medicine updated successfully!";
            header("Location: medicine-management.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "No ID provided.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medicine</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="navbar">
        <div class="navbar-container">
            <a href="admin-dashboard.html" class="logo">MedInventory</a>
            <ul class="nav-links">
                <li><a href="admin-dashboard.html">Dashboard</a></li>
                <li><a href="user-management.php">User Management</a></li>
                <li><a href="medicine-management.php">Medicine Management</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="edit-medicine">
        <h2 class="medicine-name">Edit Medicine</h2>
        <form action="edit-medicine.php?id=<?php echo $medicine['id']; ?>" method="POST">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $medicine['name']; ?>" required>
            
            <label>Category:</label>
            <input type="text" name="category" value="<?php echo $medicine['category']; ?>" required>

            <label>Price:</label>
            <input type="number" name="price" value="<?php echo $medicine['price']; ?>" required>

            <label>Stock:</label>
            <input type="number" name="stock" value="<?php echo $medicine['stock']; ?>" required>

            <label>Expiry Date:</label>
            <input type="date" name="expiry_date" value="<?php echo $medicine['expiry_date']; ?>" required>

            <button type="submit">Update Medicine</button>
        </form>
    </div>

    <script src="../js/script.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>
