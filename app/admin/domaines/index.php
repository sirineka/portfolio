<?php

session_start();
include_once '/app/requests/domaines.php';

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
    <title>Administration des domaines | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once '/app/templates/header.php'; ?>
    <main>
        <?php include_once '/app/templates/messages.php'; ?>
        <section class="container">
            <h1 class="text-center">Administration des domaines</h1>
            <a href="/admin/domaines/create.php" class="btn btn-light">Créer un domaine</a>
            <div class="card-product">
                <?php foreach (findAllDomaines() as $domaine) : ?>
                    <div class="card-product-body">
                        <!--parceque image est peut être null-->
                        <?php if ($domaine['image']) : ?>
                            <img class="card-img" src="/uploads/domaines/<?= $domaine['image']; ?>" alt="<?= $domaine['nom']; ?>">
                        <? endif; ?>
                        <h2><?= $domaine['nom']; ?></h2>
                        <div class="card-btn">
                            <a href="/admin/domaines/edit.php?id=<?= $domaine['id']; ?>" class="btn btn-light">Modifier</a>
                            <form action="/admin/domaines/delete.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce domaine?')">
                                <input type="hidden" name="id" value="<?= $domaine['id']; ?>">
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