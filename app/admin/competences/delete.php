<?php

session_start();

include_once '/app/requests/competences.php';

if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}

$competence = findAllCompetencesById(isset($_POST['id']) ? (int) $_POST['id'] : 0);

if (!$competence) {
    $_SESSION['messages']['error'] = "competence non trouvé";

    http_response_code(403);
    header('Location :/admin/competences');
    exit();
}

if (hash_equals($_SESSION['token'], $_POST['token'])) {
    if (deleteCompetences($_POST['id'])) {
        if ($competence['icon']) {
            $icon = "/app/uploads/competences/$competence[icon]";
            $_SESSION['messages']['success'] = "competence supprimée avec succés";
            if (file_exists($icon)) {
                unlink($icon);
            }
        }
    } else {
        $_SESSION['messages']['error'] = "Une erreur est survenue, try again";
    }
} else {
    $_SESSION['messages']['error'] = "Token Invalid";
}

header('Location: /admin/competences');
exit();
