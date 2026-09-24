<?php

namespace Tests;

use App\Core\Database;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * Base pour les tests de repository : chaque test s'exécute dans une
 * transaction annulée à la fin (rollback), pour ne jamais laisser de
 * données de test dans la base et pouvoir relancer les tests autant
 * de fois que nécessaire sans nettoyage manuel.
 *
 * Nécessite une base "touche_pas_au_klaxon_test" créée au préalable
 * avec database/schema-test.sql (voir README.md).
 */
abstract class DatabaseTestCase extends TestCase
{
    protected PDO $pdo;
    protected int $agenceParisId;
    protected int $agenceLyonId;
    protected int $employeId;

    protected function setUp(): void
    {
        $this->pdo = Database::getInstance();
        $this->pdo->beginTransaction();

        // Données minimales requises par les contraintes de clé étrangère
        // sur la table trajet. Comme la transaction est annulée après
        // chaque test, pas de risque de collision entre les tests.
        $this->agenceParisId = $this->insertAgence('Paris');
        $this->agenceLyonId  = $this->insertAgence('Lyon');
        $this->employeId     = $this->insertEmploye();
    }

    protected function tearDown(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }

    private function insertAgence(string $nom): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO agence (nom) VALUES (:nom)');
        // Suffixe unique pour éviter tout conflit avec la contrainte UNIQUE
        // si une transaction précédente n'a pas pu être annulée proprement.
        $stmt->execute(['nom' => $nom . '-' . uniqid()]);
        return (int) $this->pdo->lastInsertId();
    }

    private function insertEmploye(): int
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO employe (nom, prenom, email, telephone, mot_de_passe, role)
            VALUES (:nom, :prenom, :email, :telephone, :mot_de_passe, :role)
        ');
        $stmt->execute([
            'nom'          => 'Test',
            'prenom'       => 'Employe',
            'email'        => 'employe.test.' . uniqid() . '@klaxon.fr',
            'telephone'    => '0600000000',
            'mot_de_passe' => password_hash('password123', PASSWORD_DEFAULT),
            'role'         => 'employe',
        ]);
        return (int) $this->pdo->lastInsertId();
    }
}
