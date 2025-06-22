<?php
session_start();
include('db.php');
include('includes/header.php');
?>
<main>
<div class="sepet-wrapper">
<?php
// Sepet boşsa mesaj göster
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h2>Sepetiniz boş!</h2>";
} else {
    echo "<h2>Sepetiniz</h2>";
    echo "<ul class='sepet-listesi'>";
    foreach ($_SESSION['cart'] as $id => $quantity) {
        // Kampanya bilgisi çek
        $result = mysqli_query($conn, "SELECT * FROM kampanyalar WHERE id=$id");
        $row = mysqli_fetch_assoc($result);
        echo "<li>".$row['baslik']." x ".$quantity." <a href='remove_from_cart.php?id=$id'>Kaldır</a></li>";
    }
    echo "</ul>";
    echo "<a class='sepet-button' href='checkout.php'>Bağışı Tamamla</a>";
}
?>
</div>
</main>
<?php include('includes/footer.php'); ?>