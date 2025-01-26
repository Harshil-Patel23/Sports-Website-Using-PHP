<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cart_items = [];
$cart_total = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT * FROM products WHERE product_id = $product_id";
        $result = $conn->query($sql);
        if ($product = $result->fetch_assoc()) {
            $product_total = $product['price'] * $quantity;
            $cart_total += $product_total;
            $cart_items[] = [
                'id' => $product_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'total' => $product_total,
                'image_url' => $product['image_url']
            ];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $card_last4 = $_POST['card_last4'];
    $card_expiry = $_POST['card_expiry'];
    $transaction_id = 'TXN' . uniqid();
    $payment_status = "Completed";

    $conn->query("INSERT INTO orders (user_id, total_price) VALUES ($user_id, $cart_total)");
    $order_id = $conn->insert_id;
    $conn->query("INSERT INTO payments (order_id, payment_method, payment_status, transaction_id, amount, card_last4, card_expiry) 
                  VALUES ($order_id, '$payment_method', '$payment_status', '$transaction_id', $cart_total, '$card_last4', '$card_expiry')");

    foreach ($cart_items as $item) {
        $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) 
                      VALUES ($order_id, {$item['id']}, {$item['quantity']}, {$item['price']})");
    }

    unset($_SESSION['cart']);
    header("Location: confirmation.php?order_id=$order_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic styling for the checkout page */
        .cart-summary {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin: 20px auto;
            max-width: 800px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-item div {
            flex: 1;
        }

        .checkout-form {
            max-width: 800px;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .checkout-form label {
            font-weight: bold;
        }

        .checkout-form input,
        .checkout-form textarea,
        .checkout-form select,
        .checkout-form button {
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ddd;
            width: 100%;
        }

        .checkout-form button {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            border: none;
        }

        .checkout-form button:hover {
            background-color: #218838;
        }

        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>

    <script>
        function validateExpiry() {
            const expiryInput = document.getElementById('card_expiry');
            const errorMessage = document.getElementById('expiry-error');
            const expiryValue = expiryInput.value;
            const [month, year] = expiryValue.split('/').map(num => parseInt(num, 10));

            const currentDate = new Date();
            const currentMonth = currentDate.getMonth() + 1; 
            const currentYear = parseInt(currentDate.getFullYear().toString().slice(-2));

            if (month < 1 || month > 12 || year < currentYear || (year === currentYear && month < currentMonth)) {
                errorMessage.textContent = "Invalid expiry date. Please ensure the card is valid and not expired.";
                return false;
            }
            errorMessage.textContent = ""; 
            return true;
        }

        function validateForm() {
            return validateExpiry(); 
        }
    </script>
</head>

<body>
    <?php include('header.php'); ?>

    <main>
        <h1>Checkout</h1>
        <?php if ($cart_total > 0): ?>
            <div class="cart-summary">
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                        <div>
                            <p><strong><?= $item['name'] ?></strong></p>
                            <p>Price: $<?= number_format($item['price'], 2) ?></p>
                            <p>Quantity: <?= $item['quantity'] ?></p>
                            <p>Subtotal: $<?= number_format($item['total'], 2) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <h3>Total: $<?= number_format($cart_total, 2) ?></h3>
            </div>

            <form action="checkout.php" method="POST" class="checkout-form" onsubmit="return validateForm();">
                <label for="address">Shipping Address:</label>
                <textarea name="address" id="address" required></textarea>

                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                </select>

                <label for="card_last4">Card Number (Last 4 digits):</label>
                <input type="text" name="card_last4" id="card_last4" required maxlength="4" pattern="\d{4}" title="Enter the last 4 digits of the card" />

                <label for="card_expiry">Card Expiry (MM/YY):</label>
                <input type="text" name="card_expiry" id="card_expiry" required maxlength="5" pattern="\d{2}/\d{2}" title="Enter expiry date in MM/YY format" />
                <div id="expiry-error" class="error-message"></div>

                <button type="submit">Place Order</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </main>

    <?php include('footer.php'); ?>

</body>

</html>

<?php $conn->close(); ?>