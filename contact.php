<?php
session_start(); 
include('db_config.php');


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Sports E-Commerce</title>
    <link rel="stylesheet" href="style.css"> 
</head>

<body>
    <?php include('header.php'); ?>


    <main>
        <section>
            <h2>We'd love to hear from you!</h2>
            <p>If you have any questions or feedback, please reach out to us using the form below:</p>

            <!-- Contact Form -->
            <form method="POST" action="contact.php">
                <label for="name">Name:</label>
                <input autofocus type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Retrieve form data
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $message = mysqli_real_escape_string($conn, $_POST['message']);

                    if (!empty($name) && !empty($email) && !empty($message)) {
                        $query = "INSERT INTO contact_requests (name, email, message) VALUES ('$name', '$email', '$message')";
                        if (mysqli_query($conn, $query)) {
                            echo "<p>Thank you for contacting us, $name! We will get back to you shortly.</p>";
                        } else {
                            echo "<p class='error'>Error: Could not save your message. Please try again later.</p>";
                        }
                    } else {
                        echo "<p class='error'>Please fill in all fields.</p>";
                    }
                } ?>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>

    <?php include('footer.php'); ?>

</body>

</html>