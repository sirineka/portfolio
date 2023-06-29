<?php
include_once '/app/config/mysql.php';

function findAllProjets(): array
{
    global $db;
    $query = "SELECT * FROM projets";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function findAllProjetsById(int $id): array|bool
{
    global $db;
    $query = "SELECT * FROM projets WHERE id = :id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'id' => $id,
    ]);

    return $sqlStatement->fetch();
}

function createProjet(string $nom, ?string $description = null, ?string $image = null, ?string $lien = null): bool
{
    global $db;
    try {
        $query = "INSERT INTO projets (nom, description, image, lien) VALUES (:nom, :description, :image, :lien)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'nom' => $nom,
            'description' => $description,
            'image' => $image,
            'lien' => $lien,
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}

function updateProjet(int $id, string $nom, ?string $description = null, ?string $image = null, ?string $lien = null): bool
{
    global $db;
    try {
        $query = "UPDATE projets SET nom = :nom, description = :description, image = :image, lien = :lien WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
            'nom' => $nom,
            'description' => $description,
            'image' => $image,
            'lien' => $lien,

        ]);
    } catch (PDOException $e) {
        $e->getMessage();

        return false;
    }

    return true;
}

function deleteProjet(int $id): bool
{
    global $db;
    try {
        $query = "DELETE FROM projets WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
        ]);
    } catch (PDOException $e) {
        $e->getMessage();

        return false;
    }

    return true;
}
