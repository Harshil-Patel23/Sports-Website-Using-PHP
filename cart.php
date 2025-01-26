<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && !isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        if ($_SESSION['cart'][$product_id] > 1) {
            $_SESSION['cart'][$product_id]--;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .cart-header,
        .cart-item,
        .cart-total {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }

        .cart-header {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            margin-right: 20px;
            border-radius: 8px;
        }

        .cart-item-details {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-price,
        .cart-item-quantity,
        .cart-item-total,
        .cart-item-remove {
            width: 100px;
            text-align: center;
        }

        .cart-total {
            font-weight: bold;
            font-size: 1.2em;
        }

        .checkout-btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .checkout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>

    <main>
        <div class="cart-container">
            <h1>Your Cart</h1>
            <?php if (empty($_SESSION['cart'])): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <div class="cart-header">
                    <div class="cart-item-info">Product</div>
                    <div class="cart-item-price">Unit Price</div>
                    <div class="cart-item-quantity">Quantity</div>
                    <div class="cart-item-total">Total Price</div>
                    <div class="cart-item-remove">Action</div>
                </div>

                <?php
                $cart_total = 0;
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    $sql = "SELECT * FROM products WHERE product_id = $product_id";
                    $result = $conn->query($sql);
                    $product = $result->fetch_assoc();
                    $unit_price = $product['price'];
                    $total_price = $unit_price * $quantity;
                    $cart_total += $total_price;
                ?>
                    <div class="cart-item">
                        <div class="cart-item-details">
                            <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>">
                            <div class="cart-item-info">
                                <p><?= $product['name'] ?></p>
                            </div>
                        </div>
                        <div class="cart-item-price">$<?= number_format($unit_price, 2) ?></div>
                        <div class="cart-item-quantity"><?= $quantity ?></div>
                        <div class="cart-item-total">$<?= number_format($total_price, 2) ?></div>
                        <div class="cart-item-remove">
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                <button type="submit" name="remove">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>

                <div class="cart-total">
                    <div>Total:</div>
                    <div>$<?= number_format($cart_total, 2) ?></div>
                </div>
                <div style="text-align: right; padding-top: 10px;">
                    <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include('footer.php'); ?>

</body>

</html>

<?php $conn->close(); ?>