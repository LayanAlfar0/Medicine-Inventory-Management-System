<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit();
}

include('backend/db.php');

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="navbar">
        <div class="navbar-container">
            <a href="admin-dashboard.php" class="logo">MedInventory</a>
            <ul class="nav-links">
                <li><a href="admin-dashboard.php">Dashboard</a></li>
                <li><a href="user-management.php" class="active">User Management</a></li>
                <li><a href="medicine-management.php">Medicine Management</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="user-management">
        <div class="top-div">
            <h2>Manage Users</h2>
            <a href="admin-dashboard.php">Back to Dashboard</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Profile</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><img src="img/<?php echo $row['profile_pic']; ?>" alt="User" class="profile-pic"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <button><a href="edit-user.php?id=<?php echo $row['id']; ?>" style="color:white">Edit</a></button>
                        <button><a href="delete-user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')" style="color:white">Delete</a></button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button onclick="openForm()" class="add-btn">Add New User</button>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div id="form-modal" class="modal d-none">
            <div class="modal-content">
                <span class="close" onclick="closeForm()">&times;</span>
                <h3>Add New User</h3>
                <form action="add-user.php" method="POST" enctype="multipart/form-data">
                    <label>Full Name:</label>
                    <input type="text" name="name" required>
                    <label>Role:</label>
                    <select name="role">
                        <option value="admin">Admin</option>
                        <option value="staff">Pharmacy Staff</option>
                    </select>
                    
                    <label>Password:</label>
                    <input type="password" name="password" required>
                    
                    <label>Profile Picture:</label>
                    <input type="file" name="profile_pic" accept="image/*">
                    
                    <button type="submit" name="submit">Add User</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>

<?php
// Close database connection
mysqli_close($conn);
?>
