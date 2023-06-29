<?php
include_once '/app/config/mysql.php';

function findAllContact(): array
{
    global $db;
    $query = "SELECT * FROM contact";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function findContactByEmail(string $email): array | bool
{
    global $db;
    $query = "SELECT * FROM contact WHERE email = :email";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'email' => $email,
    ]);

    return $sqlStatement->fetch();
}

function createContact(string $nom, string $prenom, string $objet, string $message, string $email, ?string $telephone = null,): bool
{
    global $db;
    try {
        $query = "INSERT INTO contact(nom, prenom, objet, message, email, telephone) VALUES(:nom, :prenom, :objet, :message, :email, :telephone)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'objet' => $objet,
            'message' => $message,
            'email' => $email,
            'telephone' => $telephone,
        ]);
    } catch (PDOException $e) {
        $e->getMessage();

        return false;
    }

    return true;
}
