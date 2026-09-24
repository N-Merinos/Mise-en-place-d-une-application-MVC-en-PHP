<?php

/**
 * Configuration utilisée uniquement pendant l'exécution des tests
 * (voir phpunit.xml, qui définit APP_ENV=testing).
 *
 * Pointe vers une base séparée pour ne jamais toucher aux données réelles
 * de l'application pendant les tests.
 */

return [
    'db' => [
        'host'     => 'localhost',
        'dbname'   => 'touche_pas_au_klaxon_test',
        'user'     => 'root',
        'password' => '',
        'charset'  => 'utf8mb4',
    ],
];
