<?php
session_start();
require 'config/connexion.php';
require 'fonctions.php';
enregistrerVisite($pdo);

$succes = '';
$erreur = '';
$nom = '';
$email = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($nom) || empty($email) || empty($message)) {
        $erreur = 'Tous les champs sont obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = 'Email invalide.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO messages_contact (nom, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $email, $message]);
        $succes = 'Message envoyé avec succès !';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'composants/navigation.php'; ?>

<section>
<h2>Contactez-moi</h2>

<?php if ($succes): ?>
    <p style="color:green">✔️ <?= $succes ?></p>
<?php endif; ?>
<?php if ($erreur): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nom complet</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>" required><br>
    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br>
    <label>Message</label>
    <textarea name="message" required><?= htmlspecialchars($message) ?></textarea><br>
    <button type="submit">Envoyer</button>
</form>
</section>

<footer>
    <p>© <?= date('Y') ?> - Djamilatou</p>
</footer>
</body>
</html>