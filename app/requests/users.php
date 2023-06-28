<?php
include_once '/app/config/mysql.php';

function findAllUsers(): array{
    global $db;
    $query = "SELECT * FROM users";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function findUserByUsername(string $username): array | bool{
    global $db;
    $query = "SELECT * FROM users WHERE username = :username";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'username' => $username,
    ]);

    return $sqlStatement->fetch();

}