<?php

namespace App\Repository;

use App\Core\Database;
use PDO;

class AgenceRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    /**
     * Retourne toutes les agences, triées par nom.
     *
     * @return array<int, array{id: int, nom: string}>
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT id, nom FROM agence ORDER BY nom ASC');
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, nom FROM agence WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $nom): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO agence (nom) VALUES (:nom)');
        $stmt->execute(['nom' => $nom]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, string $nom): bool
    {
        $stmt = $this->pdo->prepare('UPDATE agence SET nom = :nom WHERE id = :id');
        return $stmt->execute(['nom' => $nom, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM agence WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
