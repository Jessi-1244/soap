<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase details </title>
    <link rel="stylesheet" href="1stpagestyle.css">
    <!-- Add any additional CSS or meta tags here -->
</head>
<body>

<main>
    <section id="Purchase">
        <h2>Purchase</h2>
        <form method="post" action="purchase_billing.php">
            <label for="customer_name">Client Name:</label>
            <input type="text" id="customer_name" name="customer_name" required><br>

            <label for="product">Product:</label>
            <input type="text" id="product" name="product" required><br>

            <label for="price_per_product">Price per Product:</label>
            <input type="number" id="price_per_product" name="price_per_product" step="0.01" required><br>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required><br>

            <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" readonly><br>

            <input type="submit" value="Submit">
        </form>
    </section>
</main>
<script src="purchase.js"></script>
<!-- Add any additional HTML content or scripts here -->

</body>
</html>
