<?php
session_start();
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];

    $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<script>alert('User already exists');</script>";
    } else {
        $sql = "INSERT INTO users (username, email, password, address) 
                VALUES ('$username', '$email', '$password', '$address')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['user_id'] = $conn->insert_id;
            header('Location: index.php');
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include('header.php'); ?>

    <main>
        <h1>Register</h1>
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input autofocus type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="address">Address:</label>
            <textarea name="address" id="address" required></textarea>

            <button type="submit">Register</button>
        </form>
    </main>
    <?php include('footer.php'); ?>

</body>

</html>

<?php $conn->close(); ?>