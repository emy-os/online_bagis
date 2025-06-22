<?php 
include('db.php'); 
include('includes/header.php'); 

error_reporting(E_ALL);
ini_set('display_errors', 1);

// URL'den id parametresini al
$kampanya_id = $_GET['id'] ?? null;

if ($kampanya_id) {
    // Veritabanından kampanya detayını çek
    $query = "SELECT * FROM kampanyalar WHERE id='$kampanya_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $kampanya = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Kampanya bulunamadı.</p>";
        include('includes/footer.php');
        exit();
    }
} else {
    echo "<p>Geçersiz kampanya ID.</p>";
    include('includes/footer.php');
    exit();
}
?>

<!-- Ortalanmış içerik kutusu -->
<div style="max-width: 800px; margin: 0 auto; text-align: center;">

    <h2><?php echo $kampanya['baslik']; ?></h2>
    <p><?php echo $kampanya['aciklama']; ?></p>
    
    <img src="img/<?php echo $kampanya['resim']; ?>" 
         alt="<?php echo $kampanya['baslik']; ?>" 
         style="max-width:300px; margin-bottom: 20px;">

    <!-- Bağış Yap Formu -->
    <form method="post" action="bagis_kaydet.php" style="margin-bottom: 20px;">
        <input type="hidden" name="kampanya_id" value="<?php echo $kampanya['id']; ?>">
        <input type="number" name="miktar" placeholder="Bağış Tutarı" required>
        <button type="submit">Bağış Yap</button>
    </form>

    <!-- Sepete Ekle Formu -->
    <form method="post" action="add_to_cart.php">
        <input type="hidden" name="id" value="<?php echo $kampanya['id']; ?>">
        <input type="number" name="miktar" placeholder="Bağış Tutarı" required>
        <button type="submit">Sepete Ekle</button>
    </form>

</div>

<?php include('includes/footer.php'); ?>