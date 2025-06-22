<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db.php');
include('includes/header.php');

$user_id = $_SESSION['user_id'];
$errors = [];
$success = '';

// Kullanıcı bilgilerini çek
$query = "SELECT adsoyad, email FROM kullanicilar WHERE id = $user_id LIMIT 1";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Form gönderilmişse işle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adsoyad = trim($_POST['adsoyad']);
    $email = trim($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $new_password_confirm = $_POST['new_password_confirm'];

    // Basit validasyonlar
    if (empty($adsoyad) || empty($email)) {
        $errors[] = "Ad Soyad ve Email boş olamaz.";
    }

    // Şifre değiştirmek istiyorsa
    if (!empty($current_password) || !empty($new_password) || !empty($new_password_confirm)) {
        // Mevcut şifreyi doğrula
        $query_pass = "SELECT sifre FROM kullanicilar WHERE id = $user_id LIMIT 1";
        $res_pass = mysqli_query($conn, $query_pass);
        $row_pass = mysqli_fetch_assoc($res_pass);

        // Şifreler hash'liyse buraya göre kontrol et (örnek md5 değilse password_verify kullanılmalı)
        if ($row_pass['sifre'] !== md5($current_password)) {
            $errors[] = "Mevcut şifre yanlış.";
        } elseif ($new_password !== $new_password_confirm) {
            $errors[] = "Yeni şifreler eşleşmiyor.";
        }
    }

    if (empty($errors)) {
        // Güncelleme sorgusu
        $update_sql = "UPDATE kullanicilar SET adsoyad = '".mysqli_real_escape_string($conn, $adsoyad)."', email = '".mysqli_real_escape_string($conn, $email)."'";

        if (!empty($new_password)) {
            $update_sql .= ", sifre = '".md5($new_password)."'";
        }

        $update_sql .= " WHERE id = $user_id";

        if (mysqli_query($conn, $update_sql)) {
            $success = "Profiliniz başarıyla güncellendi.";
            // Güncellenmiş bilgileri tekrar çek
            $result = mysqli_query($conn, $query);
            $user = mysqli_fetch_assoc($result);
        } else {
            $errors[] = "Güncelleme sırasında hata oluştu: " . mysqli_error($conn);
        }
    }
}
?>

<div class="profile-container">
  <h2>Profil Düzenle</h2>

  <?php
  if (!empty($errors)) {
      echo '<div style="color: red;"><ul>';
      foreach ($errors as $error) {
          echo "<li>$error</li>";
      }
      echo '</ul></div>';
  }

  if ($success) {
      echo "<div style='color: green;'>$success</div>";
  }
  ?>

  <form method="post" action="">
    <label>Ad Soyad:</label><br>
    <input type="text" name="adsoyad" value="<?php echo htmlspecialchars($user['adsoyad']); ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

    <h3>Şifre Değiştir</h3>

    <label>Mevcut Şifre:</label><br>
    <input type="password" name="current_password"><br><br>

    <label>Yeni Şifre:</label><br>
    <input type="password" name="new_password"><br><br>

    <label>Yeni Şifre (Tekrar):</label><br>
    <input type="password" name="new_password_confirm"><br><br>

    <button type="submit">Güncelle</button>
  </form>
</div>

<?php include('includes/footer.php'); ?>