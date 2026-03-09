<?php
session_start();
require "database.php";


// skapa tom cart om den inte finns
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Clear cart
// ----------------------------------------
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit;
}

// Om produkten läggs till via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    if ($quantity < 1) {
        $quantity = 1;
    }

    // Om produkten redan finns i cart → öka antalet
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    echo "<p>Produkten har lagts till i varukorgen!</p>";
}

?>

<h1>Din varukorg</h1>

<?php
// Om cart är tom
if (empty($_SESSION['cart'])) {
    echo "<p>Din varukorg är tom.</p>";
    echo '<a href="index.php">Tillbaka till butiken</a>';
    exit;
}

// product IDs
$ids = implode(",", array_keys($_SESSION['cart']));

// Hämta produkter från databasen
$sql = "SELECT * FROM products WHERE id IN ($ids)";
$result = $conn->query($sql);

$total = 0;

while ($row = $result->fetch_assoc()) {

    $product_id = $row['id'];
    $quantity = $_SESSION['cart'][$product_id];
    $subtotal = $row['price'] * $quantity;
    $total += $subtotal;
?>

    <div style="border:1px solid black; padding:10px; margin:10px;">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p>Pris: <?php echo $row['price']; ?> €</p>
        <p>Antal: <?php echo $quantity; ?></p>
        <p>Total: <?php echo number_format($subtotal, 2); ?> €</p>
    </div>

<?php
}
?>

<h2>Total: <?php echo number_format($total, 2); ?> €</h2>

<br>

<a href="cart.php?clear=1">Rensa varukorgen</a>
<br>
<a href="checkout.php">Gå till kassan</a>
<br>
<a href="index.php">Fortsätt handla</a>
