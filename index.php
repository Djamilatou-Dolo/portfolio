<?php

session_start();

require 'config/connexion.php';
require 'fonctions.php';
enregistrerVisite($pdo); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>Portfolio - Djamilatou</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php require 'composants/Navigation.php'; ?>

<section class="hero">
<img src="images/profil.jpg" alt="Photo de Djamilatou" class="profil">
<h2>Je transforme vos idées en sites web modernes 🚀</h2>
<p>Développeuse web junior passionnée par la création de sites rapides, modernes et responsive.</p>
<a href="contact.php" class="btn">Me contacter</a>
</section>

<section class="competences">
<h2>Mes compétences</h2>
<ul>
<li>HTML</li>
<li>CSS</li>
<li>JavaScript</li>
<li>PHP</li>
</ul>
</section>

<section class="experience">
<h2>Mes expériences</h2>
<p>Étudiante en développement web, j’ai réalisé plusieurs projets académiques : restaurant, supermarché et hôtel.</p>
</section>

<section class="projets">
<h2>Mes projets</h2>

<div class="card">
<img src="images/restaurant.jpg">
<h3>Site de restauration</h3>
<p>Site moderne avec menu et réservation.</p>
</div>

<div class="card">
<img src="images/supermarche.jpg">
<h3>Site de supermarché</h3>
<p>Plateforme e-commerce simple.</p>
</div>

<div class="card">
<img src="images/hotel.jpg">
<h3>Site d’hôtel</h3>
<p>Réservation de chambres en ligne.</p>
</div>

</section>

<?php require 'composants/pied-de-page.php'; ?>

</body>
</html>

