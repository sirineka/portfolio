<?php
session_start();
include_once '/app/requests/experiences.php';
include_once '/app/requests/domaines.php';

if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}
if (
    !empty($_POST['domaine_id']) &&
    !empty($_POST['poste']) &&
    !empty($_POST['dated']) &&
    !empty($_POST['datef']) &&
    !empty($_POST['position'])

) {
    $domaine_id = ($_POST['domaine_id']);
    $poste = strip_tags($_POST['poste']);
    $dated = ($_POST['dated']);
    $datef = ($_POST['datef']);
    $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_NUMBER_INT);

    if ($position && createExperience($domaine_id, $poste, $dated, $datef, $position)) {
        $_SESSION['messages']['success'] = "cexpérience crée avec succés";
        header(("Location: /admin/experiences"));
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
    <title>création des expériences | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <!--récupérer l'URI relatif de la page-->
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" class="form-login" method="POST">
                <h1 class="text-center">Création d'une expérience</h1>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
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
                    <label for="poste">Poste:</label>
                    <input type="text" name="poste" id="poste" placeholder="poste" required>
                </div>
                <div class="form-group">
                    <label for="dated">Date début:</label>
                    <input type="date" name="dated" id="dated">
                </div>
                <div class="form-group">
                    <label for="datef">Date fin:</label>
                    <input type="date" name="datef" id="datef">
                </div>
                <div class="form-group">
                    <label for="positinon">Position:</label>
                    <input type="number" name="position" id="position">
                </div>
                <button type="submit" class="btn btn-light" btn-light>Créer</button>
            </form>
            <a href="/admin/competences" class=" btn btn-light">Retour à la liste</a>
        </section>

    </main>
</body>

</html>