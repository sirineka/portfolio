<?php
session_start();

include_once '/app/requests/experiences.php';


if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}

$experience = findAllExperiencesById(isset($_POST['id']) ? (int) $_POST['id'] : 0);
if (!$experience) {
    $_SESSION['messages']['error'] = "experience non trouvé";

    http_response_code(403);
    header('Location :/admin/experiences');
    exit();
}
if (hash_equals($_SESSION['token'], $_POST['token'])) {
    if (deleteExperience($_POST['id'])) {
        $_SESSION['messages']['success'] = "expérience supprimée avec succés";
    } else {
        $_SESSION['messages']['error'] = "Une erreur est survenue, try again";
    }
} else {
    $_SESSION['messages']['error'] = "Token Invalid";
}

header('Location: /admin/experiences');
exit();
