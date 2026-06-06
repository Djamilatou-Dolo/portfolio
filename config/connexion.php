<?php

try {

$pdo = new PDO(
"mysql:host=localhost;dbname=portfolio;charset=utf8mb4",
"root",
""
);

$pdo->setAttribute(
PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION
);

}
catch(PDOException $e){

error_log($e->getMessage());

die("Erreur de connexion");
}