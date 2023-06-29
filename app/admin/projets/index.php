<?php

session_start();
include_once '/app/requests/projets.php';

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
    <title>Administration des projets | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <h1 class="text-center">Administration des projets</h1>
            <a href="/admin/projets/create.php" class="btn btn-light">Créer un projet</a>
            <div class="card-product">
                <?php foreach (findAllProjets() as $projet) : ?>
                    <div class="card-product-body">
                        <?php if ($projet['image']) : ?>
                            <img class="card-img" src="/uploads/projets/<?= $projet['image']; ?>" alt="<?= $projet['nom']; ?>">
                        <? endif; ?>
                        <h2><?= $projet['nom']; ?></h2>
                        <a href="<?= $projet['lien']; ?>" target="_blank"><?= $projet['lien']; ?></a>
                        <div class="card-btn" style="margin-top: 1em;">
                            <a href="/admin/projets/edit.php?id=<?= $projet['id']; ?>" class="btn btn-light">Modifier</a>
                            <form action="/admin/projets/delete.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet?')">
                                <input type="hidden" name="id" value="<?= $projet['id']; ?>">
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