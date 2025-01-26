<?php
session_start();
include('db_config.php');

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
$sql = "SELECT * FROM orders WHERE order_id = $order_id";
$result = $conn->query($sql);
$order = $result->fetch_assoc();

$sql_items = "SELECT * FROM order_items WHERE order_id = $order_id";
$result_items = $conn->query($sql_items);

$sql_user = "SELECT * FROM users WHERE user_id = " . $order['user_id'];
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include('header.php'); ?>

    <main class="order-confirmation">
        <section class="order-summary">
            <h1>Thank You for Your Order!</h1>
            <div class="order-details">
                <h3>Order ID: <span><?= $order['order_id']; ?></span></h3>
                <h3>Shipping Address: <span><?= $user['address']; ?></span></h3>
                <h3>Total Price: <span>$<?= number_format($order['total_price'], 2); ?></span></h3>
            </div>
        </section>

        <section class="order-items">
            <h4>Order Items:</h4>
            <ul>
                <?php while ($item = $result_items->fetch_assoc()): ?>
                    <?php
                    $sql_product = "SELECT * FROM products WHERE product_id = " . $item['product_id'];
                    $result_product = $conn->query($sql_product);
                    $product = $result_product->fetch_assoc();
                    ?>
                    <li>
                        <strong><?= $product['name']; ?></strong> - $<?= number_format($item['price'], 2); ?>
                        x <?= $item['quantity']; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>

        <section class="support-info">
            <p>If you have any questions, feel free to <a href="contact.php">contact us</a> at our support page.</p>
        </section>
    </main>

    <?php include('footer.php'); ?>
</body>

</html>

<?php $conn->close(); ?>