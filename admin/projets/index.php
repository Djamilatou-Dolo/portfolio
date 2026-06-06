<?php
session_start();
require '../../config/connexion.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}
$projets = $pdo->query("SELECT * FROM projets ORDER BY date_creation DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Gestion Projets</title></head>
<body>
<h1>Mes Projets</h1>
<a href="creer.php">+ Ajouter un projet</a>
<table border="1">
    <tr><th>Titre</th><th>Technologies</th><th>Actions</th></tr>
    <?php foreach ($projets as $p): ?>
    <tr>
        <td><?= htmlspecialchars($p['titre']) ?></td>
        <td><?= htmlspecialchars($p['technologies']) ?></td>
        <td>
            <a href="modifier.php?id=<?= $p['id'] ?>">Modifier</a>
            <form method="POST" action="supprimer.php" style="display:inline">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <button type="submit" onclick="return confirm('Supprimer ?')">Supprimer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="../dashboard.php">Retour dashboard</a>
</body>
</html>