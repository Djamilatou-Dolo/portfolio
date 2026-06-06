<?php
session_start();
require '../../config/connexion.php';
require '../../fonctions.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifierToken($_POST['csrf_token'])) {
    $id = (int)$_POST['id'];
    // Supprimer l'image si elle existe
    $stmt = $pdo->prepare("SELECT image FROM projets WHERE id = ?");
    $stmt->execute([$id]);
    $projet = $stmt->fetch();
    if ($projet['image']) {
        @unlink('../../images/projets/' . $projet['image']);
    }
    $stmt = $pdo->prepare("DELETE FROM projets WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: index.php');
exit;
?>