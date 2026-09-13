<?php

namespace App\Controller;

use App\Core\Auth;
use App\Repository\AgenceRepository;
use App\Repository\TrajetRepository;
use App\Core\Database;

/**
 * Toutes les actions sont réservées à l'administrateur (Auth::requireAdmin()).
 */
class AdminController
{
    private AgenceRepository $agenceRepository;
    private TrajetRepository $trajetRepository;

    public function __construct()
    {
        $this->agenceRepository = new AgenceRepository();
        $this->trajetRepository = new TrajetRepository();
    }

    /**
     * Page d'accueil du tableau de bord (liens vers les différentes sections).
     */
    public function dashboard(): void
    {
        Auth::requireAdmin();
        require __DIR__ . '/../../views/admin/dashboard.php';
    }

    // -- Agences -------------------------------------------------------

    public function listAgences(): void
    {
        Auth::requireAdmin();

        $agences = $this->agenceRepository->findAll();
        $errors = $_SESSION['form_errors'] ?? [];
        unset($_SESSION['form_errors']);

        require __DIR__ . '/../../views/admin/agences.php';
    }

    public function createAgence(): void
    {
        Auth::requireAdmin();

        $nom = trim($_POST['nom'] ?? '');

        if ($nom === '') {
            $_SESSION['form_errors'] = ["Le nom de l'agence ne peut pas être vide."];
            header('Location: /admin/agences');
            exit;
        }

        $this->agenceRepository->create($nom);

        $_SESSION['flash'] = ['type' => 'success', 'message' => "L'agence a bien été créée."];
        header('Location: /admin/agences');
        exit;
    }

    public function updateAgence(int $id): void
    {
        Auth::requireAdmin();

        $nom = trim($_POST['nom'] ?? '');

        if ($nom === '') {
            $_SESSION['form_errors'] = ["Le nom de l'agence ne peut pas être vide."];
            header('Location: /admin/agences');
            exit;
        }

        $this->agenceRepository->update($id, $nom);

        $_SESSION['flash'] = ['type' => 'success', 'message' => "L'agence a bien été modifiée."];
        header('Location: /admin/agences');
        exit;
    }

    public function deleteAgence(int $id): void
    {
        Auth::requireAdmin();

        try {
            $this->agenceRepository->delete($id);
            $_SESSION['flash'] = ['type' => 'success', 'message' => "L'agence a bien été supprimée."];
        } catch (\PDOException $e) {
            // Contrainte de clé étrangère : l'agence est utilisée par des trajets.
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => "Impossible de supprimer cette agence : elle est utilisée par des trajets existants.",
            ];
        }

        header('Location: /admin/agences');
        exit;
    }

    // -- Utilisateurs (lecture seule) -----------------------------------

    public function listUtilisateurs(): void
    {
        Auth::requireAdmin();

        $pdo = Database::getInstance();
        $utilisateurs = $pdo->query('SELECT id, nom, prenom, email, telephone, role FROM employe ORDER BY nom')->fetchAll();

        require __DIR__ . '/../../views/admin/utilisateurs.php';
    }

    // -- Trajets ---------------------------------------------------------

    public function listTrajets(): void
    {
        Auth::requireAdmin();

        $pdo = Database::getInstance();
        $sql = "
            SELECT
                t.*,
                ad.nom AS agence_depart_nom,
                aa.nom AS agence_arrivee_nom,
                e.nom AS auteur_nom,
                e.prenom AS auteur_prenom
            FROM trajet t
            JOIN agence ad ON ad.id = t.agence_depart_id
            JOIN agence aa ON aa.id = t.agence_arrivee_id
            JOIN employe e ON e.id = t.auteur_id
            ORDER BY t.date_heure_depart DESC
        ";
        $trajets = $pdo->query($sql)->fetchAll();

        require __DIR__ . '/../../views/admin/trajets.php';
    }

    public function deleteTrajet(int $id): void
    {
        Auth::requireAdmin();

        $this->trajetRepository->delete($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Le trajet a bien été supprimé.'];
        header('Location: /admin/trajets');
        exit;
    }
}
