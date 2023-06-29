<?php
session_start();

include_once '/app/requests/projets.php';
if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}
$projet = findAllProjetsById(isset($_POST['id']) ? (int) $_POST['id'] : 0);
if (!$projet) {
    $_SESSION['messages']['error'] = "projet non trouvé";

    http_response_code(403);
    header('Location :/admin/projets');
    exit();
}
if (hash_equals($_SESSION['token'], $_POST['token'])) {
    if (deleteProjet($_POST['id'])) {
        if ($projet['image']) {
            $image = "/app/uploads/projets/$projet[image]";

            $_SESSION['messages']['success'] = "projet supprimé avec succés";
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

header('Location: /admin/projets');
exit();
