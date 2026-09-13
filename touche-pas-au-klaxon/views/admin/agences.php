<?php ob_start(); ?>

<h1 class="h3 mb-4">Gestion des agences</h1>

<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
        <?= htmlspecialchars($_SESSION['flash']['message']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <table class="table table-striped">
            <thead>
                <tr><th>Nom</th><th></th></tr>
            </thead>
            <tbody>
                <?php foreach ($agences as $agence): ?>
                    <tr>
                        <td>
                            <form method="post" action="/admin/agences/<?= $agence['id'] ?>/modifier" class="d-flex gap-1">
                                <input type="text" name="nom" class="form-control form-control-sm"
                                       value="<?= htmlspecialchars($agence['nom']) ?>">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Enregistrer</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="/admin/agences/<?= $agence['id'] ?>/supprimer"
                                  onsubmit="return confirm('Supprimer cette agence ?');">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="col-md-4">
        <h2 class="h6">Nouvelle agence</h2>
        <form method="post" action="/admin/agences/creer" class="d-flex gap-2">
            <input type="text" name="nom" class="form-control" placeholder="Nom de la ville" required>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
