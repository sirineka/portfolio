<?php

session_start();
include_once '/app/requests/formations.php';
include_once '/app/requests/domaines.php';
include_once '/app/requests/competencesformations.php';

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
    <title>Administration des formations | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section>
            <h1 class="text-center">Administration des formations</h1>
            <a href="/admin/formations/create.php" class="btn btn-light mf2">Créer une formation</a>
            <div class="display-formations">
                <?php foreach (findAllFormationsWithDomaine() as $formation) : ?>
                    <div class="formations-body">
                        <div class="formation-date">
                            <h2><?= $formation['duree']; ?></h2>
                            <h2><?= $formation['date_debut'] ?></h2>
                            <h2><?= $formation['date_fin']; ?></h2>
                        </div>
                        <div class="formation-separator">
                            <span class="ligne"> </span>
                        </div>
                        <div class="formation-nom">
                            <h4><?= $formation['nom']; ?></h4>
                            <h2><?= $formation['diplome']; ?></h2>
                            <h4><?= $formation['ecole']; ?></h4>
                        </div>
                        <div>
                            <?php foreach (findCompetencesForFormation($formation['id']) as $competence) : ?>
                                <img class="icon" src="/uploads/competences/<?= $competence['icon']; ?>" alt="">
                                <p><?= $competence['description']; ?></p>
                            <?php endforeach; ?>
                        </div>
                        <div class="grid-btn-edit">
                            <a href="/admin/formations/edit.php?id=<?= $formation['id']; ?>" class="btn btn-light">Modifier</a>
                        </div>
                        <div class="grid-btn-delete">
                            <form action="/admin/formations/delete.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation?')">
                                <input type="hidden" name="id" value="<?= $formation['id']; ?>">
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