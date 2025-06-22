<?php
session_start();
include('db.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $miktar = $_POST['miktar'];
    $kampanya_id = $_POST['kampanya_id'];
    $user_id = $_SESSION['user_id'];  // Oturumdaki kullanıcı ID'si

    $query = "INSERT INTO bagislar (miktar, kampanya_id, kullanici_id) VALUES ('$miktar', '$kampanya_id', '$user_id')";

    if (mysqli_query($conn, $query)) {
        // Başarı mesajını session'a yaz
        $_SESSION['message'] = "Bağış başarıyla yapıldı!";
        // Yönlendirme
        header("Location: user_panel.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}
?>

