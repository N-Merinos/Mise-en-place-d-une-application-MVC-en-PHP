<?php

namespace App\Repository;

use App\Core\Database;
use App\Model\Trajet;
use PDO;

/**
 * Accès aux données des trajets en base.
 */
class TrajetRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    /**
     * Retourne les trajets à venir ayant encore des places disponibles,
     * triés par date de départ croissante.
     *
     * @return Trajet[]
     */
    public function findTrajetsDisponibles(): array
    {
        $sql = "
            SELECT
                t.*,
                ad.nom AS agence_depart_nom,
                aa.nom AS agence_arrivee_nom,
                e.nom AS auteur_nom,
                e.prenom AS auteur_prenom,
                e.email AS auteur_email,
                e.telephone AS auteur_telephone
            FROM trajet t
            JOIN agence ad ON ad.id = t.agence_depart_id
            JOIN agence aa ON aa.id = t.agence_arrivee_id
            JOIN employe e ON e.id = t.auteur_id
            WHERE t.date_heure_depart > NOW()
              AND t.nb_places_dispo > 0
            ORDER BY t.date_heure_depart ASC
        ";

        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll();

        return array_map([Trajet::class, 'fromArray'], $rows);
    }

    public function findById(int $id): ?Trajet
    {
        $sql = "
            SELECT
                t.*,
                ad.nom AS agence_depart_nom,
                aa.nom AS agence_arrivee_nom,
                e.nom AS auteur_nom,
                e.prenom AS auteur_prenom,
                e.email AS auteur_email,
                e.telephone AS auteur_telephone
            FROM trajet t
            JOIN agence ad ON ad.id = t.agence_depart_id
            JOIN agence aa ON aa.id = t.agence_arrivee_id
            JOIN employe e ON e.id = t.auteur_id
            WHERE t.id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? Trajet::fromArray($row) : null;
    }

    /**
     * Crée un nouveau trajet et retourne son id.
     */
    public function create(array $data): int
    {
        $sql = "
            INSERT INTO trajet
                (agence_depart_id, agence_arrivee_id, date_heure_depart,
                 date_heure_arrivee, nb_places_total, nb_places_dispo, auteur_id)
            VALUES
                (:agence_depart_id, :agence_arrivee_id, :date_heure_depart,
                 :date_heure_arrivee, :nb_places_total, :nb_places_dispo, :auteur_id)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'agence_depart_id'   => $data['agenceDepartId'],
            'agence_arrivee_id'  => $data['agenceArriveeId'],
            'date_heure_depart'  => $data['dateHeureDepart'],
            'date_heure_arrivee' => $data['dateHeureArrivee'],
            'nb_places_total'    => $data['nbPlacesTotal'],
            // À la création, toutes les places sont disponibles.
            'nb_places_dispo'    => $data['nbPlacesTotal'],
            'auteur_id'          => $data['auteurId'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM trajet WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Met à jour un trajet existant.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE trajet SET
                agence_depart_id   = :agence_depart_id,
                agence_arrivee_id  = :agence_arrivee_id,
                date_heure_depart  = :date_heure_depart,
                date_heure_arrivee = :date_heure_arrivee,
                nb_places_total    = :nb_places_total,
                nb_places_dispo    = :nb_places_dispo
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'agence_depart_id'   => $data['agenceDepartId'],
            'agence_arrivee_id'  => $data['agenceArriveeId'],
            'date_heure_depart'  => $data['dateHeureDepart'],
            'date_heure_arrivee' => $data['dateHeureArrivee'],
            'nb_places_total'    => $data['nbPlacesTotal'],
            'nb_places_dispo'    => $data['nbPlacesDispo'],
            'id'                 => $id,
        ]);
    }
}
