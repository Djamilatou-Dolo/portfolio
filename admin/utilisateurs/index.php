<?php
session_start();
require '../../config/connexion.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}
$admins = $pdo->query("SELECT id, prenom, nom, email, date_creation FROM administrateurs ORDER BY date_creation DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Administrateurs</title></head>
<body>
<h1>Administrateurs</h1>
<a href="creer.php">+ Ajouter</a> | <a href="../dashboard.php">Retour dashboard</a>
<table border="1">
    <tr><th>Prénom</th><th>Nom</th><th>Email</th><th>Date création</th><th>Actions</th></tr>
    <?php foreach ($admins as $a): ?>
    <tr>
        <td><?= htmlspecialchars($a['prenom']) ?></td>
        <td><?= htmlspecialchars($a['nom']) ?></td>
        <td><?= htmlspecialchars($a['email']) ?></td>
        <td><?= $a['date_creation'] ?></td>
        <td>
            <a href="modifier.php?id=<?= $a['id'] ?>">Modifier</a>
            <?php if ($a['id'] != $_SESSION['admin_id']): ?>
            <form method="POST" action="supprimer.php" style="display:inline">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <input type="hidden" name="id" value="<?= $a['id'] ?>">
                <button type="submit" onclick="return confirm('Supprimer ?')">Supprimer</button>
            </form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>