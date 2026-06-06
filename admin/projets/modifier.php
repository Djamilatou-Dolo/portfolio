<?php
session_start();
require '../../config/connexion.php';
require '../../fonctions.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ?");
$stmt->execute([$id]);
$projet = $stmt->fetch();

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifierToken($_POST['csrf_token'])) {
        $erreur = 'Erreur de sécurité.';
    } else {
        $titre = trim($_POST['titre']);
        $description = trim($_POST['description']);
        $technologies = trim($_POST['technologies']);
        $lien = trim($_POST['lien']);
        $image = $projet['image'];

        if (!empty($_FILES['image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $autorise = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (in_array($ext, $autorise)) {
                $nomFichier = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], '../../images/projets/' . $nomFichier);
                $image = $nomFichier;
            }
        }

        $stmt = $pdo->prepare("UPDATE projets SET titre=?, description=?, technologies=?, lien=?, image=? WHERE id=?");
        $stmt->execute([$titre, $description, $technologies, $lien, $image, $id]);
        $succes = 'Projet modifié !';
        $projet['titre'] = $titre;
        $projet['description'] = $description;
        $projet['technologies'] = $technologies;
        $projet['lien'] = $lien;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Modifier Projet</title></head>
<body>
<h1>Modifier le projet</h1>
<?php if ($erreur): ?><p style="color:red"><?= htmlspecialchars($erreur) ?></p><?php endif; ?>
<?php if ($succes): ?><p style="color:green"><?= $succes ?></p><?php endif; ?>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= genererToken() ?>">
    <input type="text" name="titre" value="<?= htmlspecialchars($projet['titre']) ?>" required><br>
    <textarea name="description" required><?= htmlspecialchars($projet['description']) ?></textarea><br>
    <input type="text" name="technologies" value="<?= htmlspecialchars($projet['technologies']) ?>" required><br>
    <input type="url" name="lien" value="<?= htmlspecialchars($projet['lien'] ?? '') ?>"><br>
    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,.gif"><br>
    <button type="submit">Modifier</button>
</form>
<a href="index.php">Retour</a>
</body>
</html>