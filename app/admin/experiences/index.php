<?php
session_start();
include_once '/app/requests/experiences.php';

if (!isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] != 1) {
    $_SESSION['messages']['error'] = 'Vous devez être connecté en admin pour accéder à cette page';
    http_response_code(403);
    header('Location: /login.php');
    exit();
}
$_SESSION['token'] = bin2hex(random_bytes(35));


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des expériences | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <h1 class="text-center">Administration des expériences</h1>
            <a href="/admin/experiences/create.php" class="btn btn-light">Créer une expérience</a>
            <div class="display-experiences">
                <?php foreach (findAllExperienceWithDomaine() as $experience) : ?>
                    <div class="experiences-body">
                        <div class="experience-nom">
                            <h2><?= $experience['nom']; ?></h2>
                            <h3><?= $experience['poste']; ?></h3>
                        </div>
                        <div class="formation-separator">
                            <span class="ligne"> </span>
                        </div>
                        <div class="experience-date">
                            <p><?= date_format(new DateTime($experience['date_debut']), 'm/y'); ?></p>
                            <p><?= date_format(new DateTime($experience['date_fin']), 'm/y'); ?></p>
                        </div>
                        <div class="grid-btn-edit">
                            <a href="/admin/experiences/edit.php?id=<?= $experience['id']; ?>" class="btn btn-light">Modifier</a>
                        </div>
                        <div class="grid-btn-delete">
                            <form action="/admin/experiences/delete.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience?')">
                                <input type="hidden" name="id" value="<?= $experience['id']; ?>">
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