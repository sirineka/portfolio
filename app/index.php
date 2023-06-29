<?php
session_start();
include_once '/app/requests/formations.php';
include_once '/app/requests/experiences.php';
include_once '/app/requests/domaines.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
    <script src="https://kit.fontawesome.com/4de17afbea.js" crossorigin="anonymous"></script>

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
        <section class="formations" id="formations">
            <div class="formations-title text-center">
                <i class="fa-sharp fa-solid fa-graduation-cap text-center" style="font-size: 3em; color: var(--primary)"></i>
                <h1 style="color: var(--secondary); font-size: 3em">Mon parcours</h1>
            </div>
            <div class="display-formations">
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
        <section class="experiences" id="experiences">
            <div class="formations-title text-center">
                <i class="fa-sharp fa-solid fa-tractor" style="font-size: 3em; color: #f5c7d7;"></i>
                <h1 style="color: var(--secondary); font-size: 3em" class="text-center">Mes expériences</h1>
            </div>
            <div class="display-experiences">
                <?php foreach (findAllExperienceWithDomaine() as $experience) : ?>
                    <div class="experiences-body">
                        <div class="experience-nom">
                            <h3 style="color: black;"><?= $experience['poste']; ?></h3>
                        </div>
                        <div class="formation-separator">
                            <span class="ligne"> </span>
                        </div>
                        <div class="experience-date">
                            <p><?= date_format(new DateTime($experience['date_debut']), 'm/Y'); ?></p>
                            <p><?= date_format(new DateTime($experience['date_fin']), 'm/Y'); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
        </section>
    </main>

</body>

</html>