-- Base de données : touche_pas_au_klaxon_test
-- Application de covoiturage inter-sites

CREATE DATABASE IF NOT EXISTS touche_pas_au_klaxon_test
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE touche_pas_au_klaxon_test;

-- ----------------------------------------------------------------------
-- Table : agence
-- ----------------------------------------------------------------------
CREATE TABLE agence (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------
-- Table : employe
-- Les employés sont importés depuis le système RH (voir seed.sql).
-- Aucun CRUD prévu dans l'application pour cette table.
-- ----------------------------------------------------------------------
CREATE TABLE employe (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    telephone VARCHAR(20) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('employe', 'admin') NOT NULL DEFAULT 'employe'
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------
-- Table : trajet
-- ----------------------------------------------------------------------
CREATE TABLE trajet (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agence_depart_id INT UNSIGNED NOT NULL,
    agence_arrivee_id INT UNSIGNED NOT NULL,
    date_heure_depart DATETIME NOT NULL,
    date_heure_arrivee DATETIME NOT NULL,
    nb_places_total TINYINT UNSIGNED NOT NULL,
    nb_places_dispo TINYINT UNSIGNED NOT NULL,
    auteur_id INT UNSIGNED NOT NULL,

    CONSTRAINT fk_trajet_agence_depart
        FOREIGN KEY (agence_depart_id) REFERENCES agence(id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_trajet_agence_arrivee
        FOREIGN KEY (agence_arrivee_id) REFERENCES agence(id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_trajet_auteur
        FOREIGN KEY (auteur_id) REFERENCES employe(id)
        ON DELETE CASCADE,

    CONSTRAINT chk_agences_differentes
        CHECK (agence_depart_id <> agence_arrivee_id),

    CONSTRAINT chk_dates_coherentes
        CHECK (date_heure_arrivee > date_heure_depart),

    CONSTRAINT chk_places_coherentes
        CHECK (nb_places_dispo <= nb_places_total)
) ENGINE=InnoDB;

CREATE INDEX idx_trajet_date_depart ON trajet(date_heure_depart);
