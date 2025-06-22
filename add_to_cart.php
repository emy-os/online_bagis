<?php
session_start();

$id = (int) $_POST['id'];
$miktar = (float) $_POST['miktar']; // Kullanıcının girdiği bağış tutarı

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Aynı kampanya varsa tutarı üzerine ekle
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += $miktar;
} else {
    $_SESSION['cart'][$id] = $miktar;
}

header("Location: kampanyalar.php");
exit();
?>