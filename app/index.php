<?php
session_start();
include_once '/app/requests/formations.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">

</head>

<body>
    <?php include_once './templates/header.php'; ?>
    <main>
        <section class="container" id="profil">
            <div class="profil">
                <div class="img-profil">
                    <img src="/assets/images/profil.jpg" alt="photo de profil" loading="lazy">
                </div>
                <span class="frame"> </span>
                <div class="text-profil">
                    <p>Ingénieure agronome de formation, j'ai récemment entrepris une reconversion profesionnelle passionnante vers le domaine du développement web et web mobile. Au cours d'une formation intensive de neufs mois, j'ai eu l'opportunité d'acquérir une solide expertise dans plusieurs langages de programmation clés. Je suis maintenant prête à relever de nouveaux défis et à contribuer activement à des projets stimulants dans le domaine du développement web.</p>
                </div>
            </div>
        </section>
        <!--<section class="container">
            <div class="pourcentage">
                <div class="div-pourcentage">95%</div>
            </div>
        </section>-->
        <section>
            <div class="display-formations">
                <h1 class="text-center" style="color: var(--secondary); font-size: 3em">Mes Formations</h1>
                <?php foreach (findAllFormationsWithDomaine() as $formation) : ?>
                    <div class="formations-body">
                        <div class="formation-date">
                            <h2><?= $formation['date_debut']; ?></h2>
                            <h2><?= $formation['date_fin']; ?></h2>
                        </div>
                        <div class="formation-separator">
                            <span class="ligne"> </span>
                        </div>
                        <div class="formation-nom">
                            <h2><?= $formation['diplome']; ?></h2>
                            <h4><?= $formation['ecole']; ?></h4>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        </section>
    </main>

</body>

</html>