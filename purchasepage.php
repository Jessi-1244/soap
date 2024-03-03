<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/3c770b8c2a.js" crossorigin="anonymous"></script>
    <title>Purchase page</title>
    <link rel="stylesheet" href="purchasepage.css">
</head>
<body>
    <div class="container">
        <div class="phone"> <i class="fa-solid fa-phone fa-beat" style="color: #74C0FC;"></i> Ph no - +91 12123233434</div>
        <div class="logo"> <i class="fa-solid fa-recycle fa-xl" style="color: #74C0FC;"></i> ALI RECYCLING</div>
        <div class="datetime" id="currentDateTime"><i class="fa-solid fa-calendar-days fa-flip" style="color: #74C0FC;"></i></div>
    </div>
    <hr>
    <div class="navbar">
        <div class="home"><button><i class="fa-solid fa-house fa-flip" style="color: #74C0FC;"></i> Home</button></div>
        <div class="statement"><button><i class="fa-solid fa-clipboard fa-flip" style="color: #74C0FC;"></i> Statement</button></div>
        <div class="logout"><button><i class="fa-solid fa-power-off fa-flip" style="color: #74C0FC;"></i>  Log-Out</button></div>
    </div>
    <p style="color: white; background: #000; display: inline; border-radius: 45px; font-size: 36px; font-family: Arial, Helvetica, sans-serif; padding: 10px; box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);">Purchase Entry Form :</p>

    <div id="purchaseForm">
    <form method="post" action="">
    <center>
        <table>
            <tr>
                <td>Date</td>
                <td><input id="dateInput" name="date" type="date"></td>
            </tr>
            <tr>
                <td>Product Name</td>
                <td><input id="productNameInput" name="product_name" type="text" placeholder="Enter the Product name"></td>
            </tr>
            <tr>
                <td>Client Name</td>
                <td><input id="ClientNameInput" name="client_name" type="text" placeholder="Enter the Clientname"></td>
            </tr>
            <tr>
                <td>Client Phone</td>
                <td><input id="clientPhoneInput" name="client_phone" type="number" placeholder="Enter the Phone number"></td>
            </tr>
            <tr>
                <td>Client Address</td>
                <td><input id="clientAddressInput" name="client_address" type="text"></td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td><input id="quantityInput" name="quantity" type="number" onchange="calculateTotalPrice()"></td>
            </tr>
            <tr>
                <td>Per Quantity Price</td>
                <td><input id="perQuantityPriceInput" name="per_quantity_price" type="number" onchange="calculateTotalPrice()"></td>
            </tr>
            <tr>
                <td>Total Price</td>
                <td><input id="totalPriceInput" name="total_price" type="text" readonly></td>
            </tr>
            <tr>
                <td><input type="reset"></td>
                <td><input type="submit"></td>
            </tr>
        </table>
    </center>
    </form>
</div>
 <!-- PHP code to display data from the database -->
 <?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $date = $_POST['date'] ?? '';
    $productName = $_POST['product_name'] ?? '';
    $clientName = $_POST['client_name'] ?? '';
    $clientPhone = $_POST['client_phone'] ?? '';
    $clientAddress = $_POST['client_address'] ?? '';
    $quantity = floatval($_POST['quantity']);
    $perQuantityPrice = floatval($_POST['per_quantity_price']);
    $totalPrice = $quantity * $perQuantityPrice;

    // Insert new purchase data into the database
    $insertSql = "INSERT INTO purchase_data(date, product_name, client_name, client_phone, client_address, quantity, per_quantity_price, total_price) 
                  VALUES ('$date', '$productName', '$clientName', '$clientPhone', '$clientAddress', '$quantity', '$perQuantityPrice', '$totalPrice')";
    if ($conn->query($insertSql) === TRUE) {
        echo "<p>New purchase added successfully!</p>";
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}

// Display data for the selected date
if (isset($_POST['date'])) {
    $selectedDate = $_POST['date'];
    $sql = "SELECT * FROM purchase_data WHERE date = '$selectedDate'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Purchases for $selectedDate</h2>";
        echo "<table><tr><th>Product Name</th><th>Client Name</th><th>Client Phone</th><th>Client Address</th><th>Quantity</th><th>Per Quantity Price</th><th>Total Price</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["product_name"] . "</td><td>" . $row["client_name"] . "</td><td>" . $row["client_phone"] . "</td><td>" . $row["client_address"] . "</td><td>" . $row["quantity"] . "</td><td>" . $row["per_quantity_price"] . "</td><td>" . $row["total_price"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No purchases found for $selectedDate</p>";
    }
}
?>


    <script>
        document.getElementById('currentDateTime').innerHTML = getCurrentDateTime();

        function getCurrentDateTime() {
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            var year = today.getFullYear();
            var hours = String(today.getHours()).padStart(2, '0');
            var minutes = String(today.getMinutes()).padStart(2, '0');
            var seconds = String(today.getSeconds()).padStart(2, '0');
            return day + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ':' + seconds;
        }
        function calculateTotalPrice() {
            var quantity = parseFloat(document.getElementById("quantityInput").value);
            var perQuantityPrice = parseFloat(document.getElementById("perQuantityPriceInput").value);
            var totalPrice = quantity * perQuantityPrice;
            document.getElementById("totalPriceInput").value = isNaN(totalPrice) ? '' : totalPrice.toFixed(2);
        }
    </script>
</body>
</html> 
