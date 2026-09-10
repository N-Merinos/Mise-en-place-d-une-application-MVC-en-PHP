<?php ob_start(); ?>

<h1 class="h3 mb-4">Trajets disponibles</h1>

<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
        <?= htmlspecialchars($_SESSION['flash']['message']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php if (empty($trajets)): ?>
    <p>Aucun trajet disponible pour le moment.</p>
<?php else: ?>
    <ul class="list-group">
        <?php foreach ($trajets as $trajet): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    <strong><?= htmlspecialchars($trajet->agenceDepartNom) ?></strong>
                    (<?= (new \DateTime($trajet->dateHeureDepart))->format('d/m/Y H:i') ?>)
                    &rarr;
                    <strong><?= htmlspecialchars($trajet->agenceArriveeNom) ?></strong>
                    (<?= (new \DateTime($trajet->dateHeureArrivee))->format('d/m/Y H:i') ?>)
                </span>
                <span class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">
                        <?= $trajet->nbPlacesDispo ?> place(s) disponible(s)
                    </span>
                    <?php if (!empty($_SESSION['user']) && $_SESSION['user']['id'] === $trajet->auteurId): ?>
                        <a href="/trajet/<?= $trajet->id ?>/modifier" class="btn btn-sm btn-outline-secondary">Modifier</a>
                        <form method="post" action="/trajet/<?= $trajet->id ?>/supprimer"
                              onsubmit="return confirm('Supprimer ce trajet ?');" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    <?php endif; ?>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
