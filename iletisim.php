<?php
session_start();
include('includes/header.php');

$name = $email = $message = '';
$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Basit validasyonlar
    if (empty($name)) $errors[] = "İsim boş bırakılamaz.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Geçerli bir e-posta giriniz.";
    if (empty($message)) $errors[] = "Mesaj boş bırakılamaz.";

    if (empty($errors)) {
        // Burada mail gönderme kodu ekleyebilirsin
        // mail($to, $subject, $message, $headers) gibi

        $success = "Mesajınız başarıyla gönderildi. Teşekkürler!";
        // Formu temizle
        $name = $email = $message = '';
    }
}
?>

<div class="contact-container">
  <h2>İletişim</h2>

  <?php if (!empty($errors)): ?>
    <div class="error-messages">
      <ul>
      <?php foreach ($errors as $error): ?>
        <li><?php echo htmlspecialchars($error); ?></li>
      <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="success-message"><?php echo $success; ?></div>
  <?php endif; ?>

  <form method="post" action="iletisim.php" class="contact-form">
    <label>Adınız:</label><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>

    <label>E-posta:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

    <label>Mesajınız:</label><br>
    <textarea name="message" rows="6" required><?php echo htmlspecialchars($message); ?></textarea><br><br>

    <button type="submit">Gönder</button>
  </form>
</div>

<?php include('includes/footer.php'); ?>