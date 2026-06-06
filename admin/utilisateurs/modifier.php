<?php
session_start();
require '../../config/connexion.php';
require '../../fonctions.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM administrateurs WHERE id = ?");
$stmt->execute([$id]);
$admin = $stmt->fetch();

$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $mdp = $_POST['mot_de_passe'];

    if (!empty($mdp)) {
        $hash = password_hash($mdp, PASSWORD_BCRYPT);
    } else {
        $hash = $admin['mot_de_passe'];
    }

    $stmt = $pdo->prepare("UPDATE administrateurs SET prenom=?, nom=?, email=?, mot_de_passe=? WHERE id=?");
    $stmt->execute([$prenom, $nom, $email, $hash, $id]);
    $succes = 'Administrateur modifié !';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Modifier admin</title></head>
<body>
<h1>Modifier administrateur</h1>
<?php if ($succes): ?><p style="color:green"><?= $succes ?></p><?php endif; ?>
<form method="POST">
    <input type="text" name="prenom" value="<?= htmlspecialchars($admin['prenom']) ?>" required><br>
    <input type="text" name="nom" value="<?= htmlspecialchars($admin['nom']) ?>" required><br>
    <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required><br>
    <input type="password" name="mot_de_passe" placeholder="Nouveau mot de passe (laisser vide = inchangé)"><br>
    <button type="submit">Modifier</button>
</form>
<a href="index.php">Retour</a>
</body>
</html>