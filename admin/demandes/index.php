<?php
session_start();
require '../../config/connexion.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pdo->prepare("UPDATE demandes_projet SET lu = 1 WHERE id = ?")->execute([$id]);
}

$demandes = $pdo->query("SELECT * FROM demandes_projet ORDER BY date_demande DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Demandes</title></head>
<body>
<h1>Demandes de projet</h1>
<a href="../dashboard.php">Retour dashboard</a>
<table border="1">
    <tr><th>Nom</th><th>Email</th><th>Type</th><th>Budget</th><th>Date</th><th>Lu</th></tr>
    <?php foreach ($demandes as $d): ?>
    <tr style="<?= $d['lu'] == 0 ? 'background:#fffacd' : '' ?>">
        <td><?= htmlspecialchars($d['nom']) ?></td>
        <td><?= htmlspecialchars($d['email']) ?></td>
        <td><?= htmlspecialchars($d['type_projet']) ?></td>
        <td><?= htmlspecialchars($d['budget'] ?? 'Non précisé') ?></td>
        <td><?= $d['date_demande'] ?></td>
        <td><?= $d['lu'] ? '✅ Lu' : '🔴 Non lu' ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>