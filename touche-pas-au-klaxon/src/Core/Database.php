<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Fournit une connexion PDO unique partagée dans toute l'application.
 */
class Database
{
    private static ?PDO $instance = null;

    /**
     * Retourne l'instance PDO, en la créant si nécessaire.
     *
     * @throws PDOException Si la connexion à la base échoue.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $configFile = (getenv('APP_ENV') === 'testing')
                ? __DIR__ . '/../../config/config.testing.php'
                : __DIR__ . '/../../config/config.php';

            $config = require $configFile;
            $db = $config['db'];

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $db['host'],
                $db['dbname'],
                $db['charset']
            );

            self::$instance = new PDO($dsn, $db['user'], $db['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }

        return self::$instance;
    }

    /**
     * Réinitialise la connexion mémorisée. Utile uniquement pour les tests,
     * qui peuvent avoir besoin de changer de configuration entre deux suites.
     */
    public static function reset(): void
    {
        self::$instance = null;
    }

    private function __construct()
    {
        // Empêche l'instanciation directe : on passe par getInstance().
    }
}
