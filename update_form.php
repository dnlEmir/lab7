<?php
session_start();
include 'Database.php';
include 'User.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// Check if the form has been submitted via GET request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matric'])) {
    // Retrieve the matric value from the GET request
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);
    $userDetails = $user->getUser($matric);

    $db->close();

    // Display the update form with the fetched user data
    if ($userDetails) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update User</title>
        </head>
        <body>
            <h1>Update User</h1>
            <form action="update.php" method="post">
                <label for="matric">matric:</label>
                <input type="text" id="matric" name="matric" value="<?php echo $userDetails['matric']; ?>"><br>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $userDetails['name']; ?>"><br>
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="">Please select</option>
                    <option value="lecturer" <?php if ($userDetails['role'] == 'lecturer') echo "selected"; ?>>Lecturer</option>
                    <option value="student" <?php if ($userDetails['role'] == 'student') echo "selected"; ?>>Student</option>
                </select><br>
                <input type="submit" value="Update"> <a href='display.php?'> cancel</a>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "User not found.";
    }
} else {
    echo "No matric value provided.";
}
?>
