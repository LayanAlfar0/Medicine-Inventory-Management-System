<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin' ) {
    header('Location: login.php'); 
    exit();
}
include('backend/db.php');

$query = "SELECT * FROM medicines";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $expiry_date = $_POST['expiry_date'];

    $insert_query = "INSERT INTO medicines (name, category, price, stock, expiry_date) 
                    VALUES ('$name', '$category', '$price', '$stock', '$expiry_date')";

    if (mysqli_query($conn, $insert_query)) {
        echo "New medicine added successfully!";
        header('Location: medicine-management.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
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
            <a href="admin-dashboard.php" class="logo">MedInventory</a>
            <ul class="nav-links">
                <li><a href="admin-dashboard.php">Dashboard</a></li>
                <li><a href="user-management.php">User Management</a></li>
                <li><a href="medicine-management.php" class="active">Medicine Management</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="medicine-management">
        <div class="top-div">
            <h2>Manage Medicines</h2>
            <a href="admin-dashboard.php">Back to Dashboard</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Expiry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['stock']; ?></td>
                        <td>$<?php echo $row['price']; ?></td>
                        <td><?php echo $row['expiry_date']; ?></td>
                        <td>
                            <button><a href="edit-medicine.php?id=<?php echo $row['id']; ?>" style="color:white">Edit</a></button>
                            <button><a href="delete-medicine.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')" style="color:white">Delete</a></button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button onclick="openForm()" class="add-btn">Add New Medicine</button>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div id="form-modal" class="modal d-none">
            <div class="modal-content">
                <span class="close" onclick="closeForm()">&times;</span>
                <h3>Add New Medicine</h3>
                <form action="medicine-management.php" method="POST">
                    <label>Name:</label>
                    <input type="text" name="name" required>
                    <label>Category:</label>
                    <input type="text" name="category" required>
                    <label>Price:</label>
                    <input type="number" name="price" required>
                    <label>Stock:</label>
                    <input type="number" name="stock" required>
                    <label>Expiry Date:</label>
                    <input type="date" name="expiry_date" required>
                    <button type="submit" name="submit">Add Medicine</button>
                </form>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>

