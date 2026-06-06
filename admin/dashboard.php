<?php
session_start();
require '../config/connexion.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: connexion.php');
    exit;
}

// Statistiques
$nbProjets = $pdo->query("SELECT COUNT(*) FROM projets")->fetchColumn();
$nbMessages = $pdo->query("SELECT COUNT(*) FROM messages_contact WHERE lu = 0")->fetchColumn();
$nbDemandes = $pdo->query("SELECT COUNT(*) FROM demandes_projet WHERE lu = 0")->fetchColumn();

// 5 dernières visites
$visites = $pdo->query("SELECT * FROM visites ORDER BY date_visite DESC LIMIT 5")->fetchAll();

// 5 dernières demandes
$demandes = $pdo->query("SELECT * FROM demandes_projet ORDER BY date_demande DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
<h1>Bonjour <?= htmlspecialchars($_SESSION['admin_prenom']) ?> !</h1>
<p>Projets : <?= $nbProjets ?></p>
<p>Messages non lus : <?= $nbMessages ?></p>
<p>Demandes non lues : <?= $nbDemandes ?></p>

<h2>Dernières visites</h2>
<table border="1">
    <tr><th>IP</th><th>Page</th><th>Date</th></tr>
    <?php foreach ($visites as $v): ?>
    <tr>
        <td><?= htmlspecialchars($v['adresse_ip']) ?></td>
        <td><?= htmlspecialchars($v['page']) ?></td>
        <td><?= $v['date_visite'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Dernières demandes</h2>
<table border="1">
    <tr><th>Nom</th><th>Type</th><th>Date</th></tr>
    <?php foreach ($demandes as $d): ?>
    <tr>
        <td><?= htmlspecialchars($d['nom']) ?></td>
        <td><?= htmlspecialchars($d['type_projet']) ?></td>
        <td><?= $d['date_demande'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="projets/index.php">Gérer les projets</a><br>
<a href="utilisateurs/index.php">Gérer les administrateurs</a><br>
<a href="messages/index.php">Voir les messages</a><br>
<a href="demandes/index.php">Voir les demandes</a><br>
<br>
<a href="deconnexion.php">Se déconnecter</a>
</body>
</html>