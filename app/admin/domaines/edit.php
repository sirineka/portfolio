<?php
session_start();
include_once '/app/requests/domaines.php';
include_once '/app/requests/competences.php';
include_once '/app/requests/competencesformations.php';


if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}
$domaine = findAllDomainesById(isset($_GET['id']) ? (int) $_GET['id'] : 0);

if (!$domaine) {
    $SESSION['messages']['error'] = "domaine non trouvé";
    http_response_code(404);
    header('Location :/admin/domaines');
    exit();
}
if (
    !empty($_POST['nom'])
) {
    $nom = strip_tags($_POST['nom']);

    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {

        if ($_FILES['image']['size'] <= 8000000) {

            $fileInfo = pathinfo($_FILES['image']['name']);
            $fileExtension = $fileInfo['extension'];
            $extensionAllowed = ['png', 'jpg', 'jpeg', 'gif', 'webm', 'webp', 'svg'];

            if (in_array($fileExtension, $extensionAllowed)) {

                $image = $fileInfo['filename'] . date('Y_m_d_H_i_s') . '.' . $fileExtension;

                move_uploaded_file($_FILES['image']['tmp_name'], "/app/uploads/domaines/$image");
                if ($domaine['image']) {
                    $oldImage = "/app/uploads/domaines/$domaine[image]";
                    //unlink: supprimer l'image

                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }
            }
        }
    }
    if (updateDomaines($domaine['id'], $nom, isset($image) ? $image : null)) {
        $_SESSION['messages']['success'] = "domaine modifié avec succés";
        header(("Location: /admin/domaines"));
        exit();
    } else {
        $errorMessage = "Une erreur est survenue, try again";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMessage = "Veuillez remplir tous les champs obligatoires";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un domaine | Potfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <!--récupérer l'URI relatif de la page-->
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" class="form-login" method="POST" enctype="multipart/form-data">
                <h1 class="text-center">Création d'un domaine</h1>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="text" name="nom" id="nom" placeholder="nom de domaine" required>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" name="image" id="image" loading="lazy">
                    </div>
                    <button type="submit" class="btn btn-light" btn-light>Créer</button>
            </form>
            <a href="/admin/domaines" class=" btn btn-light">Retour à la liste</a>
        </section>

    </main>
</body>

</html>