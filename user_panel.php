<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include('db.php');
include('includes/header.php');

$user_id = $_SESSION['user_id'];

// Kullanıcı bilgilerini çek
$query_user = "SELECT adsoyad, email, rol FROM kullanicilar WHERE id = $user_id LIMIT 1";
$result_user = mysqli_query($conn, $query_user);

if (!$result_user || mysqli_num_rows($result_user) == 0) {
    echo "<p>Kullanıcı bulunamadı.</p>";
    include('includes/footer.php');
    exit();
}

$user = mysqli_fetch_assoc($result_user);

// Toplam bağış miktarını hesapla
$query_sum = "SELECT SUM(miktar) as total_donation FROM bagislar WHERE kullanici_id = $user_id";
$result_sum = mysqli_query($conn, $query_sum);
$total = 0;
if ($result_sum && mysqli_num_rows($result_sum) > 0) {
    $row_sum = mysqli_fetch_assoc($result_sum);
    $total = $row_sum['total_donation'] ?? 0;
}

?>

<div class="profile-container">
  <h1>Hoşgeldiniz, <?php echo htmlspecialchars($user['adsoyad'] ?? $user['adsoyad']); ?></h1>
  
  <?php if (!empty($user['profile_pic'])): ?>
    <img src="../uploads/<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profil Fotoğrafı" class="profile-avatar" />
  <?php else: ?>
    <img src="../img/default-avatar.png" alt="Profil Fotoğrafı" class="profile-avatar" />
  <?php endif; ?>
  
  <p><strong>Kullanıcı Adı:</strong> <?php echo htmlspecialchars($user['adsoyad']); ?></p>
  <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
  <p><strong>Toplam Bağış Miktarı:</strong> ₺<?php echo number_format($total, 2, ',', '.'); ?></p>
  
  <a href="profile_edit.php" class="profile-edit-btn">Profili Düzenle</a>
  
  <hr>
  
  <h2>Bağış Geçmişi</h2>
  
  <table border="1" cellpadding="10" style="margin: 0 auto;">
    <tr>
      <th>Tarih</th>
      <th>Kampanya</th>
      <th>Tutar</th>
    </tr>
    <?php
    $query_donations = "SELECT b.tarih, k.baslik AS kampanya_baslik, b.miktar
                        FROM bagislar b
                        JOIN kampanyalar k ON b.kampanya_id = k.id
                        WHERE b.kullanici_id = $user_id
                        ORDER BY b.tarih DESC";
    $result_donations = mysqli_query($conn, $query_donations);
    
    if ($result_donations && mysqli_num_rows($result_donations) > 0) {
        while ($row = mysqli_fetch_assoc($result_donations)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['tarih']) . "</td>";
            echo "<td>" . htmlspecialchars($row['kampanya_baslik']) . "</td>";
            echo "<td>₺" . number_format($row['miktar'], 2, ',', '.') . "</td>";
            echo "</tr>";
        }
    } else {
        echo '<tr><td colspan="3">Hiç bağışınız bulunmuyor.</td></tr>';
    }
    ?>
  </table>
</div>


<?php include('includes/footer.php'); ?>