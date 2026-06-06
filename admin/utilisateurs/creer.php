<?php
session_start();
require '../../config/connexion.php';
require '../../fonctions.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $mdp = $_POST['mot_de_passe'];

    $hash = password_hash($mdp, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO administrateurs (prenom, nom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
    $stmt->execute([$prenom, $nom, $email, $hash]);
    $succes = 'Administrateur créé !';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Créer admin</title></head>
<body>
<h1>Créer un administrateur</h1>
<?php if ($succes): ?><p style="color:green"><?= $succes ?></p><?php endif; ?>
<?php if ($erreur): ?><p style="color:red"><?= $erreur ?></p><?php endif; ?>
<form method="POST">
    <input type="text" name="prenom" placeholder="Prénom" required><br>
    <input type="text" name="nom" placeholder="Nom" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required><br>
    <button type="submit">Créer</button>
</form>
<a href="index.php">Retour</a>
</body>
</html>