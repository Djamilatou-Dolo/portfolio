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
    if (!verifierToken($_POST['csrf_token'])) {
        $erreur = 'Erreur de sécurité.';
    } else {
        $titre = trim($_POST['titre']);
        $description = trim($_POST['description']);
        $technologies = trim($_POST['technologies']);
        $lien = trim($_POST['lien']);
        $image = null;

        // Upload image
        if (!empty($_FILES['image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $autorise = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (in_array($ext, $autorise)) {
                $nomFichier = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], '../../images/projets/' . $nomFichier);
                $image = $nomFichier;
            } else {
                $erreur = 'Format image non autorisé.';
            }
        }

        if (!$erreur) {
            $stmt = $pdo->prepare("INSERT INTO projets (titre, description, technologies, lien, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$titre, $description, $technologies, $lien, $image]);
            $succes = 'Projet créé !';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Créer Projet</title></head>
<body>
<h1>Créer un projet</h1>
<?php if ($erreur): ?><p style="color:red"><?= htmlspecialchars($erreur) ?></p><?php endif; ?>
<?php if ($succes): ?><p style="color:green"><?= $succes ?></p><?php endif; ?>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= genererToken() ?>">
    <input type="text" name="titre" placeholder="Titre" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <input type="text" name="technologies" placeholder="Technologies" required><br>
    <input type="url" name="lien" placeholder="Lien externe"><br>
    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,.gif"><br>
    <button type="submit">Créer</button>
</form>
<a href="index.php">Retour</a>
</body>
</html>