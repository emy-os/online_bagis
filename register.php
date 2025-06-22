<?php 
include('db.php');
include('includes/header.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adsoyad = $_POST['ad'];
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];

    $hashed_password = password_hash($sifre, PASSWORD_DEFAULT);

    $query = "INSERT INTO kullanicilar (adsoyad, email, sifre, rol) 
              VALUES ('$adsoyad', '$email', '$hashed_password', 'kullanici')";

    if (mysqli_query($conn, $query)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}
?>
<div class="form-wrapper">
<h2>Kayıt Ol</h2>
<form method="post" action="">
    <input type="text" name="ad" placeholder="Ad Soyad" required><br>
    <input type="email" name="email" placeholder="E-posta" required><br>
    <input type="password" name="sifre" placeholder="Şifre" required><br>
    <button type="submit">Kayıt Ol</button>
</form>
  
</div>

<?php include('includes/footer.php'); ?>