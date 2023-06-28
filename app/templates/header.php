<header class="navbar">
    <nav class="container nav">

        <div class="navbar-log">
            <a href="/">SK</a>
        </div>

        <ul class="navbar-links">
            <li class="navbar-item">
                <a href="#profil" class="navbar-link">Profil</i></a>
            </li>
            <li class="navbar-item">
                <a href="#formations" class="navbar-link">Formations</a>
            </li>
            <li class="navbar-item">
                <a href="#competences" class="navbar-link">Compétences</a>
            </li>
            <li class="navbar-item">
                <a href="#experiences" class="navbar-link">Expériences</a>
            </li>
            <li class="navbar-item">
                <a href="#projets" class="navbar-link">Projets</a>
            </li>
            <li class="navbar-item">
                <a href="#cv" class="navbar-link">CV</a>
            </li>
            <li class="navbar-item">
                <a href="#contact" class="navbar-link">Contact</a>
            </li>
        </ul>
        <?php if (isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER']['is_admin'] == 1) : ?>
            <div class="navbar-btn">

                <div class="dropdown btn btn-light">
                    <span>Admin</span>
                    <div class="dropdown-content">
                        <a href="/admin/formations" class="dropdown-link">Formations</a>
                        <a href="/admin/competences" class="dropdown-link">Compétences</a>
                        <a href="/admin/experiences" class="dropdown-link">Expériences</a>
                        <a href="/admin/projets" class="dropdown-link">Projets</a>
                        <a href="/admin/domaines" class="dropdown-link">Domaines</a>
                    </div>
                </div>
                <a href="/logout.php" class="btn btn-danger">Deconnexion</a>

            </div>
        <?php endif; ?>
    </nav>
</header>