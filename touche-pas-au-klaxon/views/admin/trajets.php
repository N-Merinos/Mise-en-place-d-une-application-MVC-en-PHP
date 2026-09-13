<?php ob_start(); ?>

<h1 class="h3 mb-4">Tous les trajets</h1>

<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
        <?= htmlspecialchars($_SESSION['flash']['message']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Auteur</th>
            <th>Places</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($trajets as $t): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($t['agence_depart_nom']) ?>
                    (<?= (new \DateTime($t['date_heure_depart']))->format('d/m/Y H:i') ?>)
                </td>
                <td>
                    <?= htmlspecialchars($t['agence_arrivee_nom']) ?>
                    (<?= (new \DateTime($t['date_heure_arrivee']))->format('d/m/Y H:i') ?>)
                </td>
                <td><?= htmlspecialchars($t['auteur_prenom'] . ' ' . $t['auteur_nom']) ?></td>
                <td><?= $t['nb_places_dispo'] ?> / <?= $t['nb_places_total'] ?></td>
                <td>
                    <form method="post" action="/admin/trajets/<?= $t['id'] ?>/supprimer"
                          onsubmit="return confirm('Supprimer ce trajet ?');">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
