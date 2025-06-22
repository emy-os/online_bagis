<?php
$servername = "localhost";
$username = "root";
$password = "";      // XAMPP'da varsayılan olarak şifre boş
$dbname = "online_bagis";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Bağlantı hatası: " . mysqli_connect_error());
}
?>