<?php

namespace App\Model;

/**
 * Représente un trajet de covoiturage proposé par un employé.
 */
class Trajet
{
    public ?int $id = null;
    public int $agenceDepartId;
    public int $agenceArriveeId;
    public string $dateHeureDepart;
    public string $dateHeureArrivee;
    public int $nbPlacesTotal;
    public int $nbPlacesDispo;
    public int $auteurId;

    // Champs supplémentaires remplis par les jointures du repository
    // (pratiques pour l'affichage, absents de la table trajet elle-même).
    public ?string $agenceDepartNom = null;
    public ?string $agenceArriveeNom = null;
    public ?string $auteurNom = null;
    public ?string $auteurPrenom = null;
    public ?string $auteurEmail = null;
    public ?string $auteurTelephone = null;

    public static function fromArray(array $row): self
    {
        $trajet = new self();
        $trajet->id                = (int) $row['id'];
        $trajet->agenceDepartId    = (int) $row['agence_depart_id'];
        $trajet->agenceArriveeId   = (int) $row['agence_arrivee_id'];
        $trajet->dateHeureDepart   = $row['date_heure_depart'];
        $trajet->dateHeureArrivee  = $row['date_heure_arrivee'];
        $trajet->nbPlacesTotal     = (int) $row['nb_places_total'];
        $trajet->nbPlacesDispo     = (int) $row['nb_places_dispo'];
        $trajet->auteurId          = (int) $row['auteur_id'];

        $trajet->agenceDepartNom   = $row['agence_depart_nom'] ?? null;
        $trajet->agenceArriveeNom  = $row['agence_arrivee_nom'] ?? null;
        $trajet->auteurNom         = $row['auteur_nom'] ?? null;
        $trajet->auteurPrenom      = $row['auteur_prenom'] ?? null;
        $trajet->auteurEmail       = $row['auteur_email'] ?? null;
        $trajet->auteurTelephone   = $row['auteur_telephone'] ?? null;

        return $trajet;
    }
}
