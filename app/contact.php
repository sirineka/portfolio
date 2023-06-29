<?php
session_start();
include_once '/app/requests/contact.php';


if (
    !empty($_POST['nom']) &&
    !empty($_POST['prenom']) &&
    !empty($_POST['objet']) &&
    !empty($_POST['message']) &&
    !empty($_POST['email'])
) {

    $nom = strip_tags($_POST['nom']);
    $prenom = strip_tags($_POST['prenom']);
    $telephone = isset($_POST['telephone']) ? strip_tags($_POST['telephone']) : null;
    $objet = strip_tags($_POST['objet']);
    $message = strip_tags($_POST['message']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!findContactByEmail($email)) {
        $contact = createContact($nom, $prenom, $telephone, $objet, $message, $email);

        if ($contact) {
            $_SESSION['messages']['success'] = "Votre message est bien envoyé";
        } else {
            $errorMessage  = "Une erreur est survenue, try again";
        }
    } else {
        $errorMessage  = "cet email est déja existant";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
    $errorMessage = "Veuillez remplir tous les champs*";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>


<body>
    <?php include_once './templates/header.php'; ?>
    <main>
        <?php include_once './templates/messages.php'; ?>
        <section class="container">
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="form">
                <h1 class="text-center">Contact</h1>

                <?php if (!empty($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Votre Nom*:</label>
                        <input type="text" name="nom" id="nom">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Votre prénom*:</label>
                        <input type="text" name="prenom" id="prenom">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Votre email*:</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="telephone">telephone:</label>
                    <input type="text" name="telephone" id="telephone">
                </div>
                <div class="form-group">
                    <label for="objet">Objet*:</label>
                    <input type="text" name="objet" id="objet">
                </div>
                <div class="form-group">
                    <label for="message">message*:</label>
                    <textarea name="message" id="message" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
            <!-- <?php
                    if (isset($_POST['message'])) {
                        $retour = mail('Karkenisirine@yahoo.fr', 'Envoi depuis la page contact', $_POST['message'], 'From: webmaster@monsite.fr' . "\r\n" . 'Reply-to: ' . $_POST['email']);
                        if ($retour)
                            echo '<p>Votre message a bien été envoyé.</p>';
                    }
                    ?>-->
        </section>
    </main>

</body>

</html>