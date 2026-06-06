<?php

function nettoyer(string $valeur): string {
    return htmlspecialchars(trim($valeur));
}

function champ_requis(string $valeur): bool {
    return !empty(trim($valeur));
}


function e($texte)
{
return htmlspecialchars(
$texte,
ENT_QUOTES,
'UTF-8'
);
}
function genererToken()
{
if(empty($_SESSION['csrf_token']))
{
$_SESSION['csrf_token']
=
bin2hex(random_bytes(32));
}

return $_SESSION['csrf_token'];
}

function verifierToken($token)
{
return hash_equals(
$_SESSION['csrf_token'],
$token
);
}
function enregistrerVisite($pdo)
{
$ip = $_SERVER['REMOTE_ADDR'];

$page = $_SERVER['PHP_SELF'];

$sql =
"INSERT INTO visites
(adresse_ip,page)
VALUES(?,?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
$ip,
$page
]);
}