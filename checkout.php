<?php
session_start();
include('db.php');
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    echo "<h2>Bağışı tamamlamak için önce giriş yapmalısınız.</h2>";
    include('includes/footer.php');
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h2>Sepetiniz boş!</h2>";
} else {
    $user_id = (int) $_SESSION['user_id'];
    $tarih = date("Y-m-d H:i:s");

    foreach ($_SESSION['cart'] as $id => $quantity) {
        $kampanya_id = (int) $id;
        $miktar = (float) $quantity;

        $query = "INSERT INTO bagislar (kullanici_id, kampanya_id, miktar, tarih)
                  VALUES ($user_id, $kampanya_id, $miktar, '$tarih')";
        mysqli_query($conn, $query);
    }

    unset($_SESSION['cart']);
    echo "<h2>Bağışınız alınmıştır! Teşekkür ederiz.</h2>";
}

include('includes/footer.php');
?>