<?php
session_start();
require 'config/connexion.php';
require 'fonctions.php';
enregistrerVisite($pdo);

$succes = '';
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $type_projet = trim($_POST['type_projet']);
    $description = trim($_POST['description']);
    $budget = trim($_POST['budget']);

    if (empty($nom) || empty($email) || empty($type_projet) || empty($description)) {
        $erreur = 'Les champs obligatoires sont manquants.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = 'Email invalide.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO demandes_projet (nom, email, type_projet, description, budget) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $email, $type_projet, $description, $budget]);
        $succes = 'Demande envoyée avec succès !';
    }
}

$projets = $pdo->query("SELECT * FROM projets ORDER BY date_creation DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Projets</title></head>
<body>
<h1>Mes Projets</h1>

<?php foreach ($projets as $p): ?>
<div>
    <h2><?= htmlspecialchars($p['titre']) ?></h2>
    <p><?= htmlspecialchars($p['description']) ?></p>
    <p>Technologies : <?= htmlspecialchars($p['technologies']) ?></p>
    <?php if ($p['image']): ?>
        <img src="images/projets/<?= htmlspecialchars($p['image']) ?>" width="200">
    <?php endif; ?>
</div>
<?php endforeach; ?>

<h2>Faire une demande de projet</h2>
<?php if ($succes): ?><p style="color:green"><?= $succes ?></p><?php endif; ?>
<?php if ($erreur): ?><p style="color:red"><?= htmlspecialchars($erreur) ?></p><?php endif; ?>
<form method="POST">
    <input type="text" name="nom" placeholder="Votre nom" required><br>
    <input type="email" name="email" placeholder="Votre email" required><br>
    <input type="text" name="type_projet" placeholder="Type de projet" required><br>
    <textarea name="description" placeholder="Description du projet" required></textarea><br>
    <input type="text" name="budget" placeholder="Budget (optionnel)"><br>
    <button type="submit">Envoyer la demande</button>
</form>
</body>
</html>