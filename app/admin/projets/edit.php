<?php
session_start();
include_once '/app/requests/projets.php';
if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}
$projet = findAllProjetsById(isset($_GET['id']) ? (int) $_GET['id'] : 0);

if (!$projet) {
    $SESSION['messages']['error'] = "Produit non trouvé";
    http_response_code(404);
    header('Location :/admin/projets');
    exit();
}
if (
    !empty($_POST['nom'])
) {
    $nom = strip_tags($_POST['nom']);
    $description = isset($_POST['description']) ? strip_tags($_POST['description']) : null;
    $lien = isset($_POST['lien']) ? strip_tags($_POST['lien']) : null;

    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
        if ($_FILES['image']['size'] <= 8000000) {
            $fileInfo = pathinfo($_FILES['image']['name']);
            $fileExtension = $fileInfo['extension'];
            $extensionAllowed = ['png', 'jpg', 'jpeg', 'gif', 'webm', 'webp', 'svg'];
            if (in_array($fileExtension, $extensionAllowed)) {

                $image = $fileInfo['filename'] . date('Y_m_d_H_i_s') . '.' . $fileExtension;

                move_uploaded_file($_FILES['image']['tmp_name'], "/app/uploads/projets/$image");
            }
        }
    }
    if (updateProjet($projet['id'], $nom, isset($description) ? $description : null, isset($image) ? $image : null, isset($lien) ? $lien : null)) {
        $_SESSION['messages']['success'] = "Projet créer avec succés";
        header(("Location: /admin/projets"));
        exit();
    } else {
        $errorMessage = "Une erreur est survenue, try again";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMessage = "Veuillez remplir tous les champs";
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création des projets | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>

    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">

            <form action="<?php $_SERVER['REQUEST_URI']; ?>" method="POST" class="form-login" enctype="multipart/form-data">
                <h1 class="text-center">Création de projet</h1>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image">
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description">
                </div>
                <div class="form-group">
                    <label for="lien">Lien</label>
                    <input type="text" name="lien" id="lien">
                </div>
                <button type="submit" class="btn btn-light" btn-light>Créer</button>
            </form>
            <a href="/admin/projets" class=" btn btn-light">Retour aux projets</a>
        </section>
    </main>
</body>

</html>