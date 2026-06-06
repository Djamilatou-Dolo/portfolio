<?php
session_start();
require '../../config/connexion.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    if ($id != $_SESSION['admin_id']) {
        $pdo->prepare("DELETE FROM administrateurs WHERE id = ?")->execute([$id]);
    }
}
header('Location: index.php');
exit;
?>