<?php 
session_start();
include('db.php'); 
include('includes/header.php'); 

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Giriş formu gönderildiyse:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];

    // Veritabanında bu email var mı?
    $query = "SELECT * FROM kullanicilar WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Şifre doğru mu?
        if (password_verify($sifre, $row['sifre'])) {
            // Doğruysa giriş başarılı!
            $_SESSION['user_id'] = $row['id'];  // Kullanıcı ID'sini session'a kaydet
            header("Location: index.php");      // Anasayfaya yönlendir
            exit();
        } else {
            echo "Hatalı şifre!";
        }
    } else {
        echo "E-posta bulunamadı!";
    }
}
?>

<div class="form-wrapper">
<h2>Giriş Yap</h2>
<form method="post" action="">
    <input type="email" name="email" placeholder="E-posta" required><br>
    <input type="password" name="sifre" placeholder="Şifre" required><br>
    <button type="submit">Giriş Yap</button>
</form>
</div>

<?php include('includes/footer.php'); ?>
