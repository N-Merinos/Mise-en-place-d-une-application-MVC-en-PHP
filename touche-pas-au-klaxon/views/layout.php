<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche pas au klaxon</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <header class="d-flex justify-content-between align-items-center px-3 py-2">
        <span class="fw-bold">Touche pas au klaxon</span>
        <?php if (empty($_SESSION['user'])): ?>
            <a href="/connexion" class="btn btn-primary">Se connecter</a>
        <?php else: ?>
            <div>
                <a href="/trajet/creer" class="btn btn-primary">Proposer un trajet</a>
                <span><?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?></span>
                <a href="/deconnexion" class="btn btn-outline-secondary">Déconnexion</a>
            </div>
        <?php endif; ?>
    </header>

    <main class="container py-4">
        <?= $content ?? '' ?>
    </main>

    <footer class="text-center py-3">
        Touche pas au klaxon &copy; <?= date('Y') ?>
    </footer>
</body>
</html>
