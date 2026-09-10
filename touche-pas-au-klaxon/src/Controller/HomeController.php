<?php

namespace App\Controller;

use App\Repository\TrajetRepository;

class HomeController
{
    private TrajetRepository $trajetRepository;

    public function __construct()
    {
        $this->trajetRepository = new TrajetRepository();
    }

    /**
     * Affiche la liste des trajets disponibles (accessible à tous).
     */
    public function index(): void
    {
        $trajets = $this->trajetRepository->findTrajetsDisponibles();

        require __DIR__ . '/../../views/home/index.php';
    }
}
