<?php

session_start();

include_once '/app/requests/formations.php';
include_once '/app/requests/competencesformations.php';

if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}

$formation = findAllFormationsById(isset($_POST['id']) ? (int) $_POST['id'] : 0);

if (!$formation) {
    $_SESSION['messages']['error'] = "formation non trouvée";

    http_response_code(404);
    header('Location :/admin/formations');
    exit();
}

if (hash_equals($_SESSION['token'], $_POST['token'])) {
    if (deleteFormations($_POST['id'])) {
        $_SESSION['messages']['success'] = "formation supprimée avec succés";
    } else {
        $_SESSION['messages']['error'] = "Une erreur est survenue, try again";
    }
} else {
    $_SESSION['messages']['error'] = "Token Invalid";
}

header('Location: /admin/formations');
exit();
