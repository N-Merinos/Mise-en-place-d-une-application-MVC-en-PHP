<?php

/**
 * Configuration de l'application.
 *
 * En production, ces valeurs devraient venir de variables d'environnement
 * plutôt que d'être codées en dur ici.
 */

return [
    'db' => [
        'host'     => 'localhost',
        'dbname'   => 'touche_pas_au_klaxon',
        'user'     => 'root',
        'password' => '',
        'charset'  => 'utf8mb4',
    ],
    'app' => [
        'name' => 'Touche pas au klaxon',
    ],
];
