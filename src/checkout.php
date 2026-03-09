<?php
session_start();
require "database.php";

// Om cart är tom, öppna produkter
if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $postal_code = trim($_POST['postal_code']);
    $city = trim($_POST['city']);
    $email = trim($_POST['email']);

    // Kontrollera om alla fält är ifyllda
    if (
        empty($first_name) || empty($last_name) ||
        empty($phone) || empty($address) ||
        empty($postal_code) || empty($city) ||
        empty($email)
    ) {
        echo "<p style='color:red;'>Alla fält är obligatoriska!</p>";
    } else {


        // (Insert) nya kunddata i databasen
        $conn->query("
    INSERT INTO customers 
    (firstname, lastname, phone, address, zipcode, city, email)
    VALUES (
        '$first_name',
        '$last_name',
        '$phone',
        '$address',
        '$postal_code',
        '$city',
        '$email'
    )
");
        $customer_id = $conn->insert_id;

        // Beräkna totalbeloppet
        $ids = implode(",", array_keys($_SESSION['cart']));
        $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");

        $total = 0;
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $quantity = $_SESSION['cart'][$row['id']];
            $subtotal = $row['price'] * $quantity;
            $total += $subtotal;

            $products[] = [
                'id' => $row['id'],
                'price' => $row['price'],
                'quantity' => $quantity
            ];
        }

        // Lägg in order
        $conn->query("
    INSERT INTO orders (customer_id, status, total_amount)
    VALUES ($customer_id, 'Ordered', $total)
");
        $order_id = $conn->insert_id;

        // Lägg in produkter (items)
        foreach ($products as $product) {

            $conn->query("
    INSERT INTO order_items (order_id, product_id, quantity, amount)
    VALUES (
        $order_id,
        {$product['id']},
        {$product['quantity']},
        {$product['price']}
    )
");
}

        // Töm cart efter genomförd beställning
        $_SESSION['cart'] = [];

        echo "<h2 style='color:green;'>Beställningen är genomförd!</h2>";
        echo "<a href='index.php'>Back to shop</a>";
        exit;
    }
}
?>

<h1>Kassa</h1>
<form method="post">
    <h3>Kundinformation</h3>
    Förnamn: <br>
    <input type="text" name="first_name"><br><br>

    Efternamn: <br>
    <input type="text" name="last_name"><br><br>

    Telefon: <br>
    <input type="text" name="phone"><br><br>

    Adress: <br>
    <input type="text" name="address"><br><br>

    Postnummer: <br>
    <input type="text" name="postal_code"><br><br>

    Stad: <br>
    <input type="text" name="city"><br><br>

    E-postadress: <br>
    <input type="email" name="email"><br><br>

    <button type="submit">Lägg beställning</button>
</form>
