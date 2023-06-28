<?php
session_start();
include_once '/app/requests/domaines.php';
include_once '/app/requests/formations.php';
include_once '/app/requests/competences.php';

if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}
if (
    !empty($_POST['domaine_id']) &&
    !empty($_POST['diplome']) &&
    !empty($_POST['ecole']) &&
    !empty($_POST['duree']) &&
    !empty($_POST['dated']) &&
    !empty($_POST['datef']) &&
    !empty($_POST['description']) &&
    !empty($_POST['position'])

) {
    $domaine_id = ($_POST['domaine_id']);
    $diplome = strip_tags($_POST['diplome']);
    $ecole = strip_tags($_POST['ecole']);
    $duree = strip_tags($_POST['duree']);
    $dated = strip_tags($_POST['dated']);
    $datef = strip_tags($_POST['datef']);
    $description = strip_tags($_POST['description']);
    $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_NUMBER_INT);
    $competences = isset($_POST['competence_id']) ? $_POST['competence_id'] : [];


    if ($position && createFormations($domaine_id, $diplome, $ecole, $duree, $dated, $datef, $description, $position)) {

        $newFormation = findLatestFormation();

        // fonction de recherche dernière formation
        if ($newFormation) {
            // foreach sur le competence_id
            foreach ($competences as $competence) {
                if ($competence > 0) {
                    // Fonction de creation comp/forma
                    createCompetenceFormation($newFormation['id'], $competence);
                }
            }
        };
        $_SESSION['messages']['success'] = "formation crée avec succés";
        header(("Location: /admin/formations"));
        exit();
    } else {
        $errorMessage = "Une erreur est survenue, try again";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMessage = "Veuillez remplir tous les champs obligatoires";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création des formations | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <!--récupérer l'URI relatif de la page-->
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" class="form-login" method="POST">
                <h1 class="text-center">Création d'une formation</h1>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="dated">Date Debut:</label>
                    <input type="text" name="dated" id="dated" placeholder="Date debut" required>
                </div>
                <div class="form-group">
                    <label for="dated">Date Fin:</label>
                    <input type="text" name="datef" id="datef" placeholder="Date fin" required>
                </div>
                <div class="form-group">
                    <label for="diplome">Diplôme</label>
                    <input type="text" name="diplome" id="diplome" placeholder="Diplôme" required>
                </div>
                <div class="form-group">
                    <label for="duree">Durée</label>
                    <input type="text" name="duree" id="duree" placeholder="Duree" required>
                </div>
                <div class="form-group">
                    <label for="ecole">Ecole:</label>
                    <input type="text" name="ecole" id="ecole" placeholder="Ecole" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" placeholder="Description" required rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="position">Position:</label>
                    <input type="number" name="position" id="position" placeholder="position" required min="0">
                </div>
                <div class="form-group">
                    <label for="domaine_id">Domaine:</label>
                    <select name="domaine_id" id="domaine_id">
                        <option value="0">Sélectionner un domaine</option>
                        <?php foreach (findAllDomaines() as $domaine) : ?>
                            <option value="<?= $domaine['id']; ?>"><?= $domaine['nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="competence_id">Compétences :</label>
                    <div class="selectBox" onclick="showCheckboxes()">
                        <select name="competence_id[]" id="competence_id">
                            <option value="0">Selectionner les compétences</option>
                        </select>
                    </div>
                    <div id="checkboxes" class="checkboxes container">
                        <?php foreach (findAllCompetences() as $competence) : ?>
                            <div class="check">
                                <input type="checkbox" id="competence_id<?= $competence['id']; ?>" name="competence_id[]" value="<?= $competence['id']; ?>">
                                <label for="competence_id<?= $competence['id']; ?>"><?= $competence['description']; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-light" btn-light>Créer</button>
            </form>
            <a href="/admin/formations" class=" btn btn-light">Retour à la liste</a>
        </section>
    </main>
    <script src="/assets/js/index.js"></script>
</body>

</html>