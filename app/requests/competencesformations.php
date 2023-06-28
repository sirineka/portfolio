<?php
include_once '/app/config/mysql.php';

function findALLCompetenceFormation(): array
{
    global $db;
    $query = "SELECT * FROM formation_competence";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}



function findTableCompetenceFormation(int $competence_id, int $formation_id): array | bool
{
    global $db;
    $query = "SELECT * FROM formation_competence WHERE competence_id = :competence_id AND formation_id = :formation_id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'competence_id' => $competence_id,
        'formation_id' => $formation_id

    ]);

    return $sqlStatement->fetchAll();
}


/**Récupérer toutes les compétences associées à une formation donnée  */
function findCompetencesForFormation(int $formation_id): array
{
    global $db;
    $query = "SELECT c.* FROM competences c JOIN formation_competence fc ON c.id = fc.competence_id WHERE fc.formation_id = :formation_id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'formation_id' => $formation_id,
    ]);

    return $sqlStatement->fetchAll();
}


/**Récupérer toutes les formations associées à une compétence donnée  */
function findFormationsForCompetence(int $competence_id): array
{
    global $db;
    $query = "SELECT f.* FROM formations f JOIN formation_competence fc ON f.id = fc.formation_id WHERE fc.competence_id = :competence_id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'competence_id' => $competence_id,
    ]);

    return $sqlStatement->fetchAll();
}

function createCompetenceFormation(int $formation_id, int $competence_id): bool
{
    global $db;
    try {
        $query = "INSERT INTO formation_competence(formation_id, competence_id) VALUES ( :formation_id, :competence_id)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'formation_id' => $formation_id,
            'competence_id' => $competence_id


        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}

function updateCompetenceFormation(int $formation_id, int $competence_id): bool
{
    global $db;
    try {
        $query = "UPDATE formation_competence SET formation_id = :formation_id, competence_id = :competence_id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'formation_id' => $formation_id,
            'competence_id' => $competence_id,
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }

    return true;
}


function deleteCompetencesFormations(int $competenceId, int $formationId): bool
{
    global $db;
    try {
        $query = "DELETE FROM formation_competence WHERE competence_id = :competenceId AND formation_id = :formationId";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'competenceId' => $competenceId,
            'formationId' => $formationId,
        ]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return false;
    }
    return true;
}
