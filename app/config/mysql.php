<?php

try {
    $db = new PDO(
        'mysql:host=caspratiqueportfolio-db-1;dbname=portfolio;charset=utf8',
        'root',
        null,//mot de passe
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);//tableau associatif
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//pour les LIMIT on va les passer
} catch (PDOException $e) {
    die($e->getMessage());
}
