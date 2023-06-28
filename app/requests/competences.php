<?php
include_once '/app/config/mysql.php';

function findAllCompetences(): array
{
    global $db;
    $query = "SELECT * FROM competences";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}


function findAllCompetencesById(int $id): array|bool
{
    global $db;
    $query = "SELECT * FROM competences WHERE id = :id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'id' => $id
    ]);

    return $sqlStatement->fetch();
}


function createCompetences(string $description, ?string $icon = null): bool
{
    global $db;
    try {
        $query = "INSERT INTO competences (description, icon) VALUES(:description, :icon)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'description' => $description,
            'icon' => $icon
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}

function updateCompetence(
    int $id,
    string $description,
    ?string $icon = null
): bool {
    global $db;
    try {
        if ($icon) {
            $query = "UPDATE competences SET 
        description = :description,
        icon = :icon
        WHERE id = :id";

            $sqlStatement = $db->prepare($query);
            $sqlStatement->execute([
                'id' => $id,
                'description' => $description,
                'icon' => $icon
            ]);
        } else {
            $query = "UPDATE competences SET 
        description = :description
        WHERE id = :id";
            $sqlStatement = $db->prepare($query);
            $sqlStatement->execute([
                'id' => $id,
                'description' => $description
            ]);
        }
    } catch (PDOException $e) {
        var_dump($e->getMessage());
        return false;
    }
    return true;
}

function deleteCompetences(int $id): bool
{
    global $db;
    try {
        $query = "DELETE FROM competences WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }
    return true;
}
