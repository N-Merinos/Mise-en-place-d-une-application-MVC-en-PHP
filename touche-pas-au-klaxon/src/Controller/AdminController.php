<?php

namespace App\Controller;

/**
 * TODO — chaque méthode doit vérifier $_SESSION['user']['role'] === 'admin'
 * (idéalement via un middleware plutôt qu'un check répété partout).
 */
class AdminController
{
    public function dashboard(): void
    {
        // TODO
    }

    public function listAgences(): void
    {
        // TODO
    }

    public function createAgence(): void
    {
        // TODO
    }

    public function updateAgence(int $id): void
    {
        // TODO
    }

    public function deleteAgence(int $id): void
    {
        // TODO
    }

    public function listUtilisateurs(): void
    {
        // TODO
    }

    public function listTrajets(): void
    {
        // TODO
    }

    public function deleteTrajet(int $id): void
    {
        // TODO
    }
}
