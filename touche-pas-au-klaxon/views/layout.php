<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche pas au klaxon</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <header class="d-flex justify-content-between align-items-center px-3 py-2">
        <?php $user = $_SESSION['user'] ?? null; ?>
        <?php if ($user && $user['role'] === 'admin'): ?>
            <a href="/admin" class="fw-bold text-decoration-none">Touche pas au klaxon</a>
            <nav class="d-flex align-items-center gap-3">
                <a href="/admin/agences">Agences</a>
                <a href="/admin/utilisateurs">Utilisateurs</a>
                <a href="/admin/trajets">Trajets</a>
                <a href="/deconnexion" class="btn btn-outline-secondary btn-sm">Déconnexion</a>
            </nav>
        <?php elseif ($user): ?>
            <span class="fw-bold">Touche pas au klaxon</span>
            <div>
                <a href="/trajet/creer" class="btn btn-primary">Proposer un trajet</a>
                <span><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></span>
                <a href="/deconnexion" class="btn btn-outline-secondary">Déconnexion</a>
            </div>
        <?php else: ?>
            <span class="fw-bold">Touche pas au klaxon</span>
            <a href="/connexion" class="btn btn-primary">Se connecter</a>
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
