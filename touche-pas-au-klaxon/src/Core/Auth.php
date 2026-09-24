<?php

namespace App\Core;

/**
 * Centralise les vérifications liées à la session utilisateur,
 * pour éviter de dupliquer les checks dans chaque contrôleur.
 */
class Auth
{
    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['user']);
    }

    public static function isAdmin(): bool
    {
        return self::isLoggedIn() && $_SESSION['user']['role'] === 'admin';
    }

    /**
     * @return array{id: int, nom: string, prenom: string, email: string, role: string}|null
     */
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Redirige vers la connexion si l'utilisateur n'est pas authentifié.
     * À appeler en première ligne des actions réservées aux employés connectés.
     */
    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            header('Location: /connexion');
            exit;
        }
    }

    /**
     * Redirige si l'utilisateur n'est pas admin.
     */
    public static function requireAdmin(): void
    {
        if (!self::isAdmin()) {
            header('Location: /');
            exit;
        }
    }
}
