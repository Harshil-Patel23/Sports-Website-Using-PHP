<?php
session_start();
include('db_config.php');

$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : '';

$sql = "SELECT * FROM products";
if ($category) {
    $sql .= " WHERE category = '$category'";
}
if ($sort_order == 'high_to_low') {
    $sql .= " ORDER BY price DESC";
} elseif ($sort_order == 'low_to_high') {
    $sql .= " ORDER BY price ASC";
}

$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .filter-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-container select,
        .filter-container label {
            font-size: 18px;
        }
    </style>

    </style>
</head>

<body>
    <?php include('header.php'); ?>


    <main>
        <h1>Products</h1>
        <form method="GET" action="products.php">
            <div class="filter-container">
                <label for="category">Category:</label>
                <select name="category" id="category" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="Football" <?= $category == 'Football' ? 'selected' : ''; ?>>Football</option>
                    <option value="Tennis" <?= $category == 'Tennis' ? 'selected' : ''; ?>>Tennis</option>
                    <option value="Basketball" <?= $category == 'Basketball' ? 'selected' : ''; ?>>Basketball</option>
                    <option value="Running" <?= $category == 'Running' ? 'selected' : ''; ?>>Running</option>
                    <option value="Swimming" <?= $category == 'Swimming' ? 'selected' : ''; ?>>Swimming</option>
                    <option value="Cycling" <?= $category == 'Cycling' ? 'selected' : ''; ?>>Cycling</option>
                    <option value="Golf" <?= $category == 'Golf' ? 'selected' : ''; ?>>Golf</option>
                    <option value="Boxing" <?= $category == 'Boxing' ? 'selected' : ''; ?>>Boxing</option>
                    <option value="Badminton" <?= $category == 'Badminton' ? 'selected' : ''; ?>>Badminton</option>
                    <option value="Yoga" <?= $category == 'Yoga' ? 'selected' : ''; ?>>Yoga</option>
                </select>

                <label for="sort">Sort by Price:</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="">Default</option>
                    <option value="low_to_high" <?= $sort_order == 'low_to_high' ? 'selected' : ''; ?>>Low to High</option>
                    <option value="high_to_low" <?= $sort_order == 'high_to_low' ? 'selected' : ''; ?>>High to Low</option>
                </select>
            </div>
        </form>

        <div class="products">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product">
                        <img src="<?= $row['image_url']; ?>" alt="<?= $row['name']; ?>">
                        <h3><?= $row['name']; ?></h3>
                        <p><?= $row['description']; ?></p>
                        <p>$<?= number_format($row['price'], 2); ?></p>
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $row['product_id']; ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include('footer.php'); ?>

</body>

</html>

<?php $conn->close(); ?>