<?php
session_start();
include_once '/app/requests/competences.php';

if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}
$competence = findAllCompetencesById(isset($_GET['id']) ? (int) $_GET['id'] : 0);

if (!$competence) {
    $SESSION['messages']['error'] = "Produit non trouvé";
    http_response_code(404);
    header('Location :/admin/competences');
    exit();
}
if (
    !empty($_POST['description'])
) {
    $description = strip_tags($_POST['description']);

    if (!empty($_FILES['icon']['name']) && $_FILES['icon']['error'] === 0) {
        // On vérifie que le fichier ne dépasse pas 8Mo
        if ($_FILES['icon']['size'] <= 8000000) {
            // On vérifie l'extension du fichier
            $fileInfo = pathinfo($_FILES['icon']['name']);
            $fileExtension = $fileInfo['extension'];
            $extensionAllowed = ['png', 'jpg', 'jpeg', 'gif', 'webm', 'webp', 'svg'];
            //si le fichier uploder $fileExtension existe dans $extensionAllowed
            if (in_array($fileExtension, $extensionAllowed)) {
                // On déplace le fichier dans le dossier uploads
                //filename c'est le nom de l'image sans extension
                $icon = $fileInfo['filename'] . date('Y_m_d_H_i_s') . '.' . $fileExtension;

                move_uploaded_file($_FILES['icon']['tmp_name'], "/app/uploads/competences/$icon");
            }
        }
    }
    if (updateCompetence($competence['id'], $description, isset($icon) ? $icon : null)) {
        $_SESSION['messages']['success'] = "competence crée avec succés";
        header(("Location: /admin/competences"));
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
    <title>Modification d'une compétence | Potfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <!--récupérer l'URI relatif de la page-->
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" class="form-login" method="POST" enctype="multipart/form-data">
                <h1 class="text-center">Modification d'une compétences</h1>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="description">description:</label>
                    <input type="text" name="description" id="description" placeholder="description" required>
                    <div class="form-group">
                        <label for="icon">Icon:</label>
                        <input type="file" name="icon" id="icon" loading="lazy">
                    </div>
                    <button type="submit" class="btn btn-light" btn-light>Créer</button>
            </form>
            <a href="/admin/competences" class=" btn btn-light">Retour à la liste</a>
        </section>

    </main>
</body>

</html>