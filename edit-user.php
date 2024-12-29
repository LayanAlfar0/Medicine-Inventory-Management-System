<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin' ) {
    header('Location: login.php'); 
    exit();
}
include('backend/db.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        die("User not found");
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    $profile_pic = $user['profile_pic'];  // Keep old profile pic if no new file is uploaded
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $fileName = $_FILES['profile_pic']['name'];
        $fileTmpName = $_FILES['profile_pic']['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png'];
        
        if (in_array($fileExtension, $allowed)) {
            $newFileName = uniqid() . "." . $fileExtension;
            $fileDestination = 'img/' . $newFileName;
            move_uploaded_file($fileTmpName, $fileDestination);
            $profile_pic = $newFileName;  // Set new profile picture filename
        }
    }

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = $user['password'];  // Keep the old password if it's not updated
    }

    $update_query = "UPDATE users SET name = '$name', role = '$role', password = '$hashed_password', profile_pic = '$profile_pic' WHERE id = '$user_id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: user-management.php");  
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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

    <div class="edit-user">
        <h2 class="user-name">Edit User: <?php echo $user['name']; ?></h2>
        <form action="edit-user.php?id=<?php echo $user['id']; ?>" method="POST" enctype="multipart/form-data">
            <label>Full Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

            <label>Role:</label>
            <select name="role">
                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="staff" <?php echo ($user['role'] == 'staff') ? 'selected' : ''; ?>>Pharmacy Staff</option>
            </select>

            <label>Password (leave blank to keep current):</label>
            <input type="password" name="password">

            <label>Profile Picture:</label>
            <input type="file" name="profile_pic" accept="image/*">

            <button type="submit" name="submit">Update User</button>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>
