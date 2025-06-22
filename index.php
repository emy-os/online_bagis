<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db.php');               // Veritabanı bağlantısı
include('includes/header.php'); // Header

// Toplam bağış miktarını çek
$query = "SELECT SUM(miktar) AS toplam_bagis FROM bagislar";
$result = mysqli_query($conn, $query);

$toplam_bagis = 0;
if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row && isset($row['toplam_bagis'])) {
        $toplam_bagis = (float)$row['toplam_bagis'];
    }
}
?>

<!-- Hero Alanı -->
<div class="hero" style="text-align: center; padding: 60px 20px; background-color: #fff4e0;">
    <h1 style="font-size: 36px; color:rgb(244, 239, 236);">Bir Umut Işığı Ol</h1>
    <p style="font-size: 20px; color: white;">İhtiyaç sahiplerine umut olun, bağışlarınızla destek verin.</p>
</div>

<!-- Toplam Bağış Miktarı -->
<section class="istatistik" style="
    max-width: 600px;
    margin: 60px auto;
    background: #fffaf2;
    border: 2px solid #ffd6a0;
    border-radius: 15px;
    padding: 40px 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    text-align: center;">
    <h2 style="font-size: 28px; color: #e65c00; margin-bottom: 10px;">Toplam Bağış Miktarı</h2>
    <p style="font-size: 32px; font-weight: bold; color: #333;">
        ₺<?php echo number_format($toplam_bagis, 2, ',', '.'); ?>
    </p>
    <p style="font-size: 16px; color: #666;">Sizlerin destekleriyle bu rakama ulaşıldı. Teşekkür ederiz!</p>
</section>

<!-- Misyon & Vizyon -->
<section class="misyon-vizyon" style="background-color: #fff6e6; padding: 60px 20px; text-align: center;">
    <h2 style="color: #cc5200; font-size: 28px; margin-bottom: 30px;">Misyonumuz & Vizyonumuz</h2>
    <div style="max-width: 800px; margin: auto; font-size: 18px; line-height: 1.6; color: #444;">
        <p><strong>🌍 Misyon:</strong> İhtiyaç sahibi bireylere en hızlı ve güvenilir şekilde yardım ulaştırmak; yardımlaşma kültürünü dijital dünyaya taşıyarak toplumsal dayanışmayı güçlendirmek.</p>
        <p><strong>🚀 Vizyon:</strong> Türkiye'nin en güvenilir bağış platformu olmak; şeffaf, erişilebilir ve sürdürülebilir bir yardım ağı oluşturmak.</p>
    </div>
</section>

<!-- İletişim Kısmı -->
<section class="homepage-contact" style="max-width: 800px; margin: 40px auto; padding: 20px;">
    <h3 style="color: #e65c00; font-size: 24px;">İletişim</h3>
    <p>Email: <a href="mailto:info@umutkoprusu.com">info@umutkoprusu.com</a></p>
    <p>Telefon: 0123 456 78 90</p>
    <p><a href="iletisim.php" style="color: #cc5200; font-weight: bold;">Detaylı iletişim sayfası için tıklayın</a></p>
</section>

<?php include('includes/footer.php'); ?>