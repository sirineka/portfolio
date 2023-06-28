<?php
session_start();
include_once '/app/requests/users.php';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = strip_tags($_POST['username']);
    $password = $_POST['password'];

    $verifUser = findUserByUsername($username);

    if ($verifUser && password_verify($password, $verifUser['password'])) {
        $_SESSION['LOGGED_USER'] = [
            'id' => $verifUser['id'],
            'username' => $verifUser['username'],
            'is_admin' => $verifUser['is_admin']
        ];


        header('Location: /login.php');
        exit();
    } else {

        $errorMessage = "Identifiant incorrecte";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
    $errorMessage = "Veuillez remplir tous les champs obligatoires";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Portfolio</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
    <?php include_once './templates/header.php'; ?>
    <main>
        <?php include_once './templates/messages.php'; ?>
        <section class="container">
            <form action="<?php $_SERVER['REQUEST_URI']; ?>" method="POST" class="form-login">
                <h1 class="text-center">Connexion</h1>
                <?php if (!empty($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <p><?= $errorMessage; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="username">Votre username: </label>
                    <input type="text" name="username" id="username" placeholder="John">
                </div>
                <div class="form-group">
                    <label for="password">Votre mot de passe: </label>
                    <input type="password" name="password" id="password" placeholder="********">
                </div>
                <button type="submit" class="btn btn-light">Connexion</button>
            </form>
        </section>
    </main>

</body>

</html>