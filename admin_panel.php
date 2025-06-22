<?php 
include('db.php'); // Bağlantı!
include('includes/header.php'); 

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<h2>Admin Paneli</h2>
<p>Burada kampanya ekleme, düzenleme, silme işlemleri yapılabilir.</p>

<table border="1" cellpadding="10">
  <tr>
    <th>ID</th>
    <th>Başlık</th>
    <th>Açıklama</th>
    <th>Toplam Bağış</th>
    <th>İşlem</th>
  </tr>

  <?php
  // Veritabanından kampanyaları çek
  $query = "SELECT * FROM kampanyalar";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>".$row['id']."</td>";
          echo "<td>".$row['baslik']."</td>";
          echo "<td>".$row['aciklama']."</td>";
          echo "<td>₺".$row['toplam_bagis']."</td>";
          echo "<td>Düzenle | Sil</td>";
          echo "</tr>";
      }
  } else {
      echo "<tr><td colspan='5'>Kayıt yok</td></tr>";
  }
  ?>
</table>

<?php include('includes/footer.php'); ?>
