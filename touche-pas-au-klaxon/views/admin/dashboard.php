<?php ob_start(); ?>

<h1 class="h3 mb-4">Tableau de bord administrateur</h1>

<div class="list-group col-md-4">
    <a href="/admin/agences" class="list-group-item list-group-item-action">Gérer les agences</a>
    <a href="/admin/utilisateurs" class="list-group-item list-group-item-action">Lister les utilisateurs</a>
    <a href="/admin/trajets" class="list-group-item list-group-item-action">Lister / supprimer les trajets</a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
