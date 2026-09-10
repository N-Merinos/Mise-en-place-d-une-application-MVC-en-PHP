<?php

namespace App\Controller;

use App\Core\Auth;
use App\Repository\AgenceRepository;
use App\Repository\TrajetRepository;

/**
 * TODO restant : edit(), update(), delete() — même logique de validation
 * que store(), plus une vérification que l'utilisateur est bien l'auteur.
 */
class TrajetController
{
    private TrajetRepository $trajetRepository;
    private AgenceRepository $agenceRepository;

    public function __construct()
    {
        $this->trajetRepository = new TrajetRepository();
        $this->agenceRepository = new AgenceRepository();
    }

    /**
     * Affiche le formulaire de création (réservé aux employés connectés).
     */
    public function create(): void
    {
        Auth::requireLogin();

        $agences = $this->agenceRepository->findAll();
        $user = Auth::user();
        $errors = $_SESSION['form_errors'] ?? [];
        $old = $_SESSION['form_old'] ?? [];
        unset($_SESSION['form_errors'], $_SESSION['form_old']);

        require __DIR__ . '/../../views/trajet/create.php';
    }

    /**
     * Valide et enregistre le trajet, puis redirige vers la liste
     * avec un message flash (consigne : "message lui indique la réussite").
     */
    public function store(): void
    {
        Auth::requireLogin();

        $data = [
            'agenceDepartId'   => (int) ($_POST['agence_depart_id'] ?? 0),
            'agenceArriveeId'  => (int) ($_POST['agence_arrivee_id'] ?? 0),
            'dateHeureDepart'  => $_POST['date_heure_depart'] ?? '',
            'dateHeureArrivee' => $_POST['date_heure_arrivee'] ?? '',
            'nbPlacesTotal'    => (int) ($_POST['nb_places_total'] ?? 0),
            'auteurId'         => Auth::user()['id'],
        ];

        $errors = $this->validate($data);

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old'] = $_POST;
            header('Location: /trajet/creer');
            exit;
        }

        $this->trajetRepository->create($data);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Votre trajet a bien été enregistré.',
        ];
        header('Location: /');
        exit;
    }

    /**
     * Contrôles de cohérence exigés par le brief :
     * agences différentes, arrivée après le départ, places > 0.
     *
     * @return string[] Liste des messages d'erreur (vide si le formulaire est valide).
     */
    private function validate(array $data): array
    {
        $errors = [];

        if ($data['agenceDepartId'] <= 0 || $data['agenceArriveeId'] <= 0) {
            $errors[] = "Veuillez sélectionner une agence de départ et une agence d'arrivée.";
        } elseif ($data['agenceDepartId'] === $data['agenceArriveeId']) {
            $errors[] = "L'agence de départ et l'agence d'arrivée doivent être différentes.";
        }

        $depart = \DateTime::createFromFormat('Y-m-d\TH:i', $data['dateHeureDepart']);
        $arrivee = \DateTime::createFromFormat('Y-m-d\TH:i', $data['dateHeureArrivee']);

        if (!$depart || !$arrivee) {
            $errors[] = 'Merci de renseigner des dates de départ et d\'arrivée valides.';
        } else {
            if ($arrivee <= $depart) {
                $errors[] = "La date d'arrivée doit être postérieure à la date de départ.";
            }
            if ($depart < new \DateTime('now')) {
                $errors[] = 'La date de départ ne peut pas être dans le passé.';
            }
        }

        if ($data['nbPlacesTotal'] < 1) {
            $errors[] = 'Le nombre de places doit être au moins 1.';
        }

        return $errors;
    }

    public function edit(int $id): void
    {
        // TODO : même schéma que create(), + vérifier auteur === user courant
    }

    public function update(int $id): void
    {
        // TODO : même schéma que store(), + vérifier auteur === user courant
    }

    public function delete(int $id): void
    {
        Auth::requireLogin();

        $trajet = $this->trajetRepository->findById($id);

        if (!$trajet) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Ce trajet n\'existe pas.'];
            header('Location: /');
            exit;
        }

        if ($trajet->auteurId !== Auth::user()['id']) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Vous ne pouvez supprimer que vos propres trajets.'];
            header('Location: /');
            exit;
        }

        $this->trajetRepository->delete($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Le trajet a bien été supprimé.'];
        header('Location: /');
        exit;
    }
}
