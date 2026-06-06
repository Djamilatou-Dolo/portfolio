<?php
session_start();
require '../config/connexion.php';
require '../fonctions.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $stmt = $pdo->prepare("SELECT * FROM administrateurs WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    echo "<pre>";
echo "Hash en base : " . $admin['mot_de_passe'] . "\n";
echo "Verify result : ";
var_dump(password_verify($_POST['mot_de_passe'], $admin['mot_de_passe']));
echo "</pre>";

    if ($admin && password_verify($_POST['mot_de_passe'], $admin['mot_de_passe'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_prenom'] = $admin['prenom'];
        header('Location: dashboard.php');
        exit;
    } else {
        $erreur = 'Identifiants incorrects.';
        // Debug temporaire :
        var_dump($admin);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
</head>
<body>
<h1>Espace Administration</h1>
<?php if ($erreur): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= genererToken() ?>">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="mot_de_passe" placeholder="Mot de passe">
    <button type="submit">Se connecter</button>
</form>
</body>
</html>