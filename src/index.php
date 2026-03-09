<?php 
session_start();
require "database.php";

// Förbered SQL för att hämta produkter
$sql = "SELECT id, name, description, price, image FROM products";

$stmt = $conn->prepare($sql);

$stmt->execute();

// get_result()
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Webbshop</title>
</head>
<body>

<h1>Våra produkter</h1>

<div class="container" style= "display:flex; justify-content: space-evenly;">
    <?php
// Kontrollera om produkter finns, sedan gå igenom dem
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>


        <div style="border:1px solid black; padding:10px; margin:10px; width:200px; text-align:center;">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <img src="<?php echo htmlspecialchars($row['image']); ?>" width="150" height="150">
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <p>Pris: <?php echo $row['price']; ?> kr</p>


            <!-- cart form -->
            <form method="post" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit">Lägg till i varukorgen</button>
            </form>
        </div>

<?php
    }

} else {
    echo "<p>No products available.</p>";
}
?>
</div>

</body>
</html>