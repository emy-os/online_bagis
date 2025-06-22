<?php 
include('db.php'); // Veritabanı bağlantısı
include('includes/header.php'); 

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<h2 style="text-align:center;">Aktif Kampanyalar</h2>

<div class="kampanyalar">
    <?php
    // Tüm kampanyaları veritabanından çek
    $query = "SELECT * FROM kampanyalar";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="kampanya">';
            echo '<img src="img/'.$row['resim'].'" alt="'.$row['baslik'].'">';
            echo '<h3>'.$row['baslik'].'</h3>';
            echo '<p>'.$row['aciklama'].'</p>';
            echo '<a href="campaign_detail.php?id='.$row['id'].'">Detay</a>';

            echo "<form method='post' action='add_to_cart.php'>
    <input type='hidden' name='id' value='".$row['id']."'>
    <button type='submit'>Sepete Ekle</button>
</form>";

            echo '</div>';
        }
    } else {
        echo '<p>Henüz kampanya bulunmuyor.</p>';
    }
    ?>
</div>

<?php include('includes/footer.php'); ?>
