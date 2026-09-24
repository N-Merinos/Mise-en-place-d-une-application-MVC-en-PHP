<?php ob_start(); ?>

<h1 class="h3 mb-4">Trajets disponibles</h1>

<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
        <?= htmlspecialchars($_SESSION['flash']['message']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php $user = $_SESSION['user'] ?? null; ?>

<?php if (!$user): ?>
    <p class="text-muted">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter.</p>
<?php endif; ?>

<?php if (empty($trajets)): ?>
    <p>Aucun trajet disponible pour le moment.</p>
<?php else: ?>
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Départ</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Destination</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Places</th>
                <?php if ($user): ?><th></th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trajets as $trajet): ?>
                <?php
                    $depart = new \DateTime($trajet->dateHeureDepart);
                    $arrivee = new \DateTime($trajet->dateHeureArrivee);
                    $estAuteur = $user && $user['id'] === $trajet->auteurId;
                ?>
                <tr>
                    <td><?= htmlspecialchars($trajet->agenceDepartNom) ?></td>
                    <td><?= $depart->format('d/m/Y') ?></td>
                    <td><?= $depart->format('H:i') ?></td>
                    <td><?= htmlspecialchars($trajet->agenceArriveeNom) ?></td>
                    <td><?= $arrivee->format('d/m/Y') ?></td>
                    <td><?= $arrivee->format('H:i') ?></td>
                    <td><?= $trajet->nbPlacesDispo ?></td>
                    <?php if ($user): ?>
                        <td class="text-nowrap">
                            <button type="button" class="btn btn-sm btn-link p-0 me-2" title="Détails"
                                    data-bs-toggle="modal" data-bs-target="#details-<?= $trajet->id ?>">
                                👁
                            </button>
                            <?php if ($estAuteur): ?>
                                <a href="/trajet/<?= $trajet->id ?>/modifier" class="btn btn-sm btn-link p-0 me-2" title="Modifier">✏️</a>
                                <form method="post" action="/trajet/<?= $trajet->id ?>/supprimer"
                                      onsubmit="return confirm('Supprimer ce trajet ?');" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-link p-0 text-danger" title="Supprimer">🗑️</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($user): ?>
        <?php foreach ($trajets as $trajet): ?>
            <!-- Fenêtre modale de détails (section 3.5 du brief) -->
            <div class="modal fade" id="details-<?= $trajet->id ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Détails du trajet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <p>Auteur : <strong><?= htmlspecialchars($trajet->auteurPrenom . ' ' . $trajet->auteurNom) ?></strong></p>
                            <p>Téléphone : <strong><?= htmlspecialchars($trajet->auteurTelephone) ?></strong></p>
                            <p>Email : <strong><?= htmlspecialchars($trajet->auteurEmail) ?></strong></p>
                            <p>Nombre total de places : <strong><?= $trajet->nbPlacesTotal ?></strong></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
