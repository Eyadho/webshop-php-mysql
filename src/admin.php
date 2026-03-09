<?php
require "database.php";
session_start();


// Ta bort order
if (isset($_GET['delete'])) {
    $order_id = (int) $_GET['delete'];
    $conn->query("DELETE FROM orders WHERE id = $order_id");
    header("Location: admin.php");
    exit;
}

// Uppdatera order status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = (int) $_POST['order_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status = '$status' WHERE id = $order_id");
    header("Location: admin.php");
    exit;
}
?>

<h1>Admin - Beställningar</h1>

<?php
// Hämta all info
$orders = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");

while ($order = $orders->fetch_assoc()) {
    $order_id = $order['id'];
    $customer_id = $order['customer_id'];

    // Hämta kunder för denna beställning
    $customer_result = $conn->query("SELECT * FROM customers WHERE id = $customer_id");
    $customer = $customer_result->fetch_assoc();
?>

    <div style="border:1px solid black; padding:15px; margin:15px; width: fit-content;">
        
        <h3>Beställning #<?php echo $order_id; ?></h3>

        <p>
            Kund:
            <?php echo htmlspecialchars($customer['firstname'] . " " . $customer['lastname']); ?>
            (<?php echo htmlspecialchars($customer['email']); ?>)
        </p>

        <p>Status: <?php echo $order['status']; ?></p>
        <p>Totalbelopp: <?php echo $order['total_amount']; ?> kr</p>
        <p>Datum: <?php echo $order['order_date']; ?></p>

        <!-- Status Form  -->
        <form method="post">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

            <select name="status">
                <option value="Ordered">Ordered</option>
                <option value="Packed">Packed</option>
                <option value="Shipped">Shipped</option>
                <option value="Paid">Paid</option>
            </select>

            <button type="submit" name="update_status">
                Uppdatera Status
            </button>
        </form>

        <!-- Delete Button -->
        <a href="admin.php?delete=<?php echo $order_id; ?>">
            Ta bort beställning
        </a>

        <h4>Produkter:</h4>

        <?php
        // Hämta (order items)
        $items = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");

        while ($item = $items->fetch_assoc()) {
            $product_id = $item['product_id'];

            // Hämta produkter info
            $product_result = $conn->query("SELECT * FROM products WHERE id = $product_id");
            $product = $product_result->fetch_assoc();
        ?>

            <p>
                <?php echo htmlspecialchars($product['name']); ?> —
                Antal: <?php echo $item['quantity']; ?> —
                Pris: <?php echo $item['amount']; ?> kr
            </p>

        <?php } ?>

    </div>

<?php } ?>
