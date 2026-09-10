<?php ob_start(); ?>

<h1 class="h3 mb-4">Proposer un trajet</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/trajet/creer" class="col-md-6">

    <fieldset class="mb-3" disabled>
        <legend class="h6">Vos coordonnées (pré-remplies, non modifiables)</legend>
        <input type="text" class="form-control mb-2" value="<?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>">
        <input type="text" class="form-control" value="<?= htmlspecialchars($user['email']) ?>">
    </fieldset>

    <div class="mb-3">
        <label for="agence_depart_id" class="form-label">Agence de départ</label>
        <select class="form-select" id="agence_depart_id" name="agence_depart_id" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($agences as $agence): ?>
                <option value="<?= $agence['id'] ?>" <?= (($old['agence_depart_id'] ?? '') == $agence['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($agence['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="agence_arrivee_id" class="form-label">Agence d'arrivée</label>
        <select class="form-select" id="agence_arrivee_id" name="agence_arrivee_id" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($agences as $agence): ?>
                <option value="<?= $agence['id'] ?>" <?= (($old['agence_arrivee_id'] ?? '') == $agence['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($agence['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row">
        <div class="col mb-3">
            <label for="date_heure_depart" class="form-label">Date et heure de départ</label>
            <input type="datetime-local" class="form-control" id="date_heure_depart"
                   name="date_heure_depart" value="<?= htmlspecialchars($old['date_heure_depart'] ?? '') ?>" required>
        </div>
        <div class="col mb-3">
            <label for="date_heure_arrivee" class="form-label">Date et heure d'arrivée</label>
            <input type="datetime-local" class="form-control" id="date_heure_arrivee"
                   name="date_heure_arrivee" value="<?= htmlspecialchars($old['date_heure_arrivee'] ?? '') ?>" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="nb_places_total" class="form-label">Nombre de places proposées</label>
        <input type="number" class="form-control" id="nb_places_total" name="nb_places_total"
               min="1" max="8" value="<?= htmlspecialchars($old['nb_places_total'] ?? '') ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Publier le trajet</button>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
