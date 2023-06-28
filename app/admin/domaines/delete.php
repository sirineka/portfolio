<?php

session_start();

include_once '/app/requests/domaines.php';

if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}

$domaine = findAllDomainesById(isset($_POST['id']) ? (int) $_POST['id'] : 0);

if (!$domaine) {
    $_SESSION['messages']['error'] = "domaine non trouvé";

    http_response_code(404);
    header('Location :/admin/domaines');
    exit();
}

if (hash_equals($_SESSION['token'], $_POST['token'])) {
    if (deleteDomaines($_POST['id'])) {
        if ($domaine['image']) {
            $image = "/app/uploads/domaines/$domaine[image]";

            $_SESSION['messages']['success'] = "domaine supprimé avec succés";
            if (file_exists($image)) {
                unlink($image);
            }
        }
    } else {
        $_SESSION['messages']['error'] = "Une erreur est survenue, try again";
    }
} else {
    $_SESSION['messages']['error'] = "Token Invalid";
}

header('Location: /admin/domaines');
exit();
