<?php
include_once '/app/config/mysql.php';

function findAllDomaines(): array
{
    global $db;
    $query = "SELECT * FROM domaine";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}


/**
 * find domaine by id
 *
 * @param integer $id
 * @return array|boolean
 */
function findAllDomainesById(int $id): array|bool
{
    global $db;
    $query = "SELECT * FROM domaine WHERE id = :id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'id' => $id
    ]);

    return $sqlStatement->fetch();
}


/**
 * creation de table domaine
 *
 * @param string $nom
 * @param string|null $image
 * @return boolean
 */
function createDomaines(string $nom, ?string $image = null): bool
{
    global $db;
    try {
        $query = "INSERT INTO domaine(nom, image) VALUES(:nom, :image)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'nom' => $nom,
            'image' => $image
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}

function updateDomaines(
    int $id,
    string $nom,
    ?string $image = null
): bool {
    global $db;
    try {
        if ($image) {
            $query = "UPDATE domaine SET 
        nom = :nom,
        image = :image
        WHERE id = :id";

            $sqlStatement = $db->prepare($query);
            $sqlStatement->execute([
                'id' => $id,
                'nom' => $nom,
                'image' => $image
            ]);
        } else {
            $query = "UPDATE domaine SET 
        nom = :nom
        WHERE id = :id";
            $sqlStatement = $db->prepare($query);
            $sqlStatement->execute([
                'id' => $id,
                'nom' => $nom
            ]);
        }
    } catch (PDOException $e) {
        var_dump($e->getMessage());
        return false;
    }
    return true;
}

function deleteDomaines(int $id): bool
{
    global $db;
    try {
        $query = "DELETE FROM domaine WHERE id = :id";
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
