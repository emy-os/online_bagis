<?php
// Session başlatılmamışsa başlat:
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Umut Köprüsü</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js" defer></script>
</head>
<body>
<header>
    <h1>💙 Umut Köprüsü</h1>
    <nav>
        <a href="index.php">Anasayfa</a>
        <a href="kampanyalar.php">Kampanyalar</a>
        <a href="cart.php">🛒 Sepetim</a>
        <a href="iletisim.php">İletişim</a> <!-- Buraya ekle -->

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="user_panel.php">Profilim</a>
            <a href="logout.php">Çıkış Yap</a>
        <?php else: ?>
            <a href="login.php">Giriş Yap</a>
            <a href="register.php">Kayıt Ol</a>
        <?php endif; ?>
    </nav>
</header>