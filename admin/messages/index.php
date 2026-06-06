<?php
session_start();
require '../../config/connexion.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

// Marquer comme lu si on clique sur un message
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pdo->prepare("UPDATE messages_contact SET lu = 1 WHERE id = ?")->execute([$id]);
}

$messages = $pdo->query("SELECT * FROM messages_contact ORDER BY date_envoi DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Messages</title></head>
<body>
<h1>Messages de contact</h1>
<a href="../dashboard.php">Retour dashboard</a>
<table border="1">
    <tr><th>Nom</th><th>Email</th><th>Message</th><th>Date</th><th>Lu</th></tr>
    <?php foreach ($messages as $m): ?>
    <tr style="<?= $m['lu'] == 0 ? 'background:#fffacd' : '' ?>">
        <td><?= htmlspecialchars($m['nom']) ?></td>
        <td><?= htmlspecialchars($m['email']) ?></td>
        <td>
            <a href="?id=<?= $m['id'] ?>">
                <?= htmlspecialchars(substr($m['message'], 0, 50)) ?>...
            </a>
        </td>
        <td><?= $m['date_envoi'] ?></td>
        <td><?= $m['lu'] ? '✅ Lu' : '🔴 Non lu' ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>