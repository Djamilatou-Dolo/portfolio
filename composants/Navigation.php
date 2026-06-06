<?php
$page_courante = basename($_SERVER['PHP_SELF']);
?>

<nav>
  <a href="index.php" <?= $page_courante == 'index.php' ? 'class="actif"' : '' ?>>Accueil</a>
  <a href="projets.php" <?= $page_courante == 'projets.php' ? 'class="actif"' : '' ?>>Projets</a>
  <a href="contact.php" <?= $page_courante == 'contact.php' ? 'class="actif"' : '' ?>>Contact</a>
</nav>