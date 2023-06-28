<?php

session_start();
include_once '/app/requests/competences.php';

if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}

$_SESSION['token'] = bin2hex(random_bytes(35));

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des compétences | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <h1 class="text-center">Administration des competences</h1>
            <a href="/admin/competences/create.php" class="btn btn-light">Créer une compétence</a>
            <div class="grid-competences">
                <?php foreach (findAllCompetences() as $competence) : ?>
                    <div class="grid-body">
                        <!--parceque image est peut être null-->
                        <div class="grid-icon">
                            <?php if ($competence['icon']) : ?>
                                <img class="icon" src="/uploads/competences/<?= $competence['icon']; ?>" alt="" ; ?>
                            <? endif; ?>
                        </div>
                        <div class="grid-descri">
                            <p><?= $competence['description']; ?></p>
                        </div>
                        <div class="grid-btn-edit">
                            <a href="/admin/competences/edit.php?id=<?= $competence['id']; ?>" class="btn btn-light">Modifier</a>
                        </div>
                        <div class="grid-btn-delete">
                            <form action="/admin/competences/delete.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence?')">
                                <input type="hidden" name="id" value="<?= $competence['id']; ?>">
                                <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                                <button type="submit" class="btn btn-dark">Supprimer</button>
                            </form>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        </section>

    </main>


</body>

</html>