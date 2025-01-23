<?php
session_start();
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['address'] = $user['address'];

            header('Location: index.php');
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that username/email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include('header.php'); ?>

    <main>
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <label for="username">Username or Email:</label>
            <input autofocus type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
            <?php if (isset($error)) : ?>
                <p style="color: red;"><?= $error; ?></p>
            <?php endif; ?>
        </form>
        <br />
        <p style="text-align: center;">Don't have an account? <a href="register.php">Register here</a></p><br />
    </main>
    <?php include('footer.php'); ?>

</body>

</html>

<?php $conn->close(); ?>