<?php
include_once '/app/config/mysql.php';

function findAllExperiences(): array
{
    global $db;
    $query = "SELECT * FROM experiences";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function findAllExperiencesById(int $id): array|bool
{
    global $db;
    $query = "SELECT * FROM experiences WHERE id = :id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'id' => $id,
    ]);

    return $sqlStatement->fetch();
}

function findAllExperienceWithDomaine(): array
{
    global $db;

    $query = "SELECT e.*, d.nom FROM experiences e JOIN domaine d ON d.id=e.domaine_id ORDER BY e.position ASC";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function createExperience(int $domaine_id, string $poste, string $dated, string $datef, int $position,): bool
{
    global $db;
    try {
        $query = "INSERT INTO experiences (domaine_id, poste, date_debut, date_fin, position) VALUES (:domaine_id, :poste, :dated, :datef, :position)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'domaine_id' => $domaine_id,
            'poste' => $poste,
            'dated' => $dated,
            'datef' => $datef,
            'position' => $position
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}

function updateExperience(int $id, int $domaine_id, string $poste, string $dated, string $datef, int $position): bool
{
    global $db;
    try {
        $query = "UPDATE experiences SET domaine_id = :domaine_id, poste = :poste, date_debut = :dated, date_fin = :datef, position = :position WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
            'domaine_id' => $domaine_id,
            'poste' => $poste,
            'dated' => $dated,
            'datef' => $datef,
            'position' => $position

        ]);
    } catch (PDOException $e) {
        $e->getMessage();

        return false;
    }

    return true;
}

function deleteExperience(int $id): bool
{
    global $db;
    try {
        $query = "DELETE FROM experiences WHERE id = :id";
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
