USE touche_pas_au_klaxon;

-- ----------------------------------------------------------------------
-- Agences
-- ----------------------------------------------------------------------
INSERT INTO agence (nom) VALUES
    ('Paris'),
    ('Lyon'),
    ('Rennes'),
    ('Lille'),
    ('Bordeaux');

-- ----------------------------------------------------------------------
-- Employés
-- Mot de passe en clair pour référence : "password123"
-- Hash généré avec password_hash('password123', PASSWORD_DEFAULT)
-- ----------------------------------------------------------------------
INSERT INTO employe (nom, prenom, email, telephone, mot_de_passe, role) VALUES
    ('Admin', 'Système', 'admin@klaxon.fr', '0600000000',
     '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'admin'),
    ('Dupont', 'Julie', 'julie.dupont@klaxon.fr', '0611111111',
     '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Martin', 'Paul', 'paul.martin@klaxon.fr', '0622222222',
     '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Bernard', 'Lucie', 'lucie.bernard@klaxon.fr', '0633333333',
     '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe');

-- ----------------------------------------------------------------------
-- Trajets (dates dans le futur pour rester visibles sur la page d'accueil)
-- ----------------------------------------------------------------------
INSERT INTO trajet (agence_depart_id, agence_arrivee_id, date_heure_depart, date_heure_arrivee, nb_places_total, nb_places_dispo, auteur_id) VALUES
    (1, 3, DATE_ADD(NOW(), INTERVAL 2 DAY), DATE_ADD(NOW(), INTERVAL 2 DAY) + INTERVAL 4 HOUR, 4, 3, 2),
    (3, 1, DATE_ADD(NOW(), INTERVAL 3 DAY), DATE_ADD(NOW(), INTERVAL 3 DAY) + INTERVAL 4 HOUR, 4, 4, 3),
    (2, 4, DATE_ADD(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 1 DAY) + INTERVAL 5 HOUR, 3, 1, 4),
    (4, 5, DATE_ADD(NOW(), INTERVAL 5 DAY), DATE_ADD(NOW(), INTERVAL 5 DAY) + INTERVAL 6 HOUR, 4, 0, 2);
