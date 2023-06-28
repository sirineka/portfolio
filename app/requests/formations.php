<?php
include_once '/app/config/mysql.php';
include_once '/app/requests/competencesformations.php';

function findAllFormations(): array
{
    global $db;
    $query = "SELECT * FROM formations";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}


/**
 * find formations by id
 *
 * @param integer $id
 * @return array|boolean
 */
function findAllFormationsById(int $id): array|bool
{
    global $db;
    $query = "SELECT * FROM formations WHERE id = :id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'id' => $id
    ]);

    return $sqlStatement->fetch();
}

function findLatestFormation(): array|bool
{
    // récupérer l'article (Limit 1) order by ID desc
    global $db;
    $query = "SELECT * FROM formations ORDER BY id DESC LIMIT 1";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetch();
}


function findAllFormationsWithDomaine(): array
{
    global $db;

    $query = "SELECT f.*, d.nom FROM formations f JOIN domaine d ON d.id=f.domaine_id ORDER BY f.position ASC";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function findFormationsWithCompetences(): array
{
    global $db;
    $query = "SELECT f.*,c.icon, c.description as descri FROM formations f JOIN  formation_competence fc ON f.id=fc.formation_id JOIN competences c ON c.id=fc.competence_id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}


function createFormations(int $domaine_id, string $diplome, string $ecole, string $duree, string $dated, string $datef, string $description, int $position): bool
{
    global $db;
    try {
        $query = "INSERT INTO formations(domaine_id, diplome, ecole, duree, date_debut, date_fin, description, position) VALUES (:domaine_id, :diplome, :ecole, :duree, :dated, :datef, :description, :position)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'domaine_id' => $domaine_id,
            'diplome' => $diplome,
            'ecole' => $ecole,
            'duree' => $duree,
            'dated' => $dated,
            'datef' => $datef,
            'description' => $description,
            'position' => $position

        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}


function updateFormations(int $id, int $domaine_id, string $diplome, string $ecole, string $duree, string $dated, string $datef, string $description, int $position): bool
{
    global $db;
    try {
        $query = "UPDATE formations SET domaine_id = :domaine_id, diplome = :diplome, ecole = :ecole, duree = :duree, date_debut = :dated, date_fin = :datef, description = :description, position = :position WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
            'domaine_id' => $domaine_id,
            'diplome' => $diplome,
            'ecole' => $ecole,
            'duree' => $duree,
            'dated' => $dated,
            'datef' => $datef,
            'description' => $description,
            'position' => $position
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}

function deleteFormations(int $id): bool
{
    global $db;
    try {
        $query = "DELETE FROM formations WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }
    return true;
}
