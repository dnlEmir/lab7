<?php
session_start();
// Include the database and user class files
require_once 'Database.php';
require_once 'User.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
// Initialize the Database and User classes
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Fetch all users
$users = $user->getUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($users->num_rows > 0) {
            // Output data of each row
            while($row = $users->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["matric"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["role"] . "</td>";
                echo "<td>";
                echo "<a href='update_form.php?matric=" . $row["matric"] . "'>Update</a> | ";
                echo "<a href='delete.php?matric=" . $row["matric"] . "'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        ?>
    </table>
</body>
<a href="logout.php">Log Out</a>
</html>
