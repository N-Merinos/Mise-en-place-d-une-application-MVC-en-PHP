USE touche_pas_au_klaxon;

-- ----------------------------------------------------------------------
-- Agences (source : annexe jeu-d-essais/agences.txt)
-- ----------------------------------------------------------------------
INSERT INTO agence (nom) VALUES
    ('Paris'),
    ('Lyon'),
    ('Marseille'),
    ('Toulouse'),
    ('Nice'),
    ('Nantes'),
    ('Strasbourg'),
    ('Montpellier'),
    ('Bordeaux'),
    ('Lille'),
    ('Rennes'),
    ('Reims');

-- ----------------------------------------------------------------------
-- Compte administrateur
-- L'annexe RH (jeu-d-essais/users.txt) ne fournit ni mot de passe ni
-- rôle : aucun des employés listés n'y est désigné comme admin. Ce
-- compte est donc ajouté séparément pour permettre l'accès au tableau
-- de bord administrateur.
-- Mot de passe en clair : "password123"
-- ----------------------------------------------------------------------
INSERT INTO employe (nom, prenom, email, telephone, mot_de_passe, role) VALUES
    ('Admin', 'Système', 'admin@klaxon.fr', '0600000000',
     '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'admin');

-- ----------------------------------------------------------------------
-- Employés (source : annexe jeu-d-essais/users.txt, nom/prenom/telephone/email)
-- Comme l'annexe ne fournit pas de mot de passe, un mot de passe par
-- défaut identique est appliqué à tous : "password123"
-- (hash bcrypt identique à celui de l'admin ci-dessus).
-- ----------------------------------------------------------------------
INSERT INTO employe (nom, prenom, email, telephone, mot_de_passe, role) VALUES
    ('Martin', 'Alexandre', 'alexandre.martin@email.fr', '0612345678', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Dubois', 'Sophie', 'sophie.dubois@email.fr', '0698765432', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Bernard', 'Julien', 'julien.bernard@email.fr', '0622446688', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Moreau', 'Camille', 'camille.moreau@email.fr', '0611223344', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Lefèvre', 'Lucie', 'lucie.lefevre@email.fr', '0777889900', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Leroy', 'Thomas', 'thomas.leroy@email.fr', '0655443322', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Roux', 'Chloé', 'chloe.roux@email.fr', '0633221199', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Petit', 'Maxime', 'maxime.petit@email.fr', '0766778899', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Garnier', 'Laura', 'laura.garnier@email.fr', '0688776655', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Dupuis', 'Antoine', 'antoine.dupuis@email.fr', '0744556677', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Lefebvre', 'Emma', 'emma.lefebvre@email.fr', '0699887766', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Fontaine', 'Louis', 'louis.fontaine@email.fr', '0655667788', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Chevalier', 'Clara', 'clara.chevalier@email.fr', '0788990011', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Robin', 'Nicolas', 'nicolas.robin@email.fr', '0644332211', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Gauthier', 'Marine', 'marine.gauthier@email.fr', '0677889922', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Fournier', 'Pierre', 'pierre.fournier@email.fr', '0722334455', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Girard', 'Sarah', 'sarah.girard@email.fr', '0688665544', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Lambert', 'Hugo', 'hugo.lambert@email.fr', '0611223366', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Masson', 'Julie', 'julie.masson@email.fr', '0733445566', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe'),
    ('Henry', 'Arthur', 'arthur.henry@email.fr', '0666554433', '$2b$10$nEEMpm//1hkLntVqLHIPduELA9l7oOWbkywxRFI/lTmwClTLl7B3e', 'employe');

-- ----------------------------------------------------------------------
-- Trajets
-- Identifiants (dans l'ordre d'insertion ci-dessus) :
--   Agences : 1 Paris, 2 Lyon, 3 Marseille, 4 Toulouse, 5 Nice, 6 Nantes,
--             7 Strasbourg, 8 Montpellier, 9 Bordeaux, 10 Lille, 11 Rennes, 12 Reims
--   Employés : 1 Admin, 2 Martin, 3 Dubois, 4 Bernard, 5 Moreau, 6 Lefèvre, 7 Leroy, ...
--
-- Jeu volontairement varié pour tester les règles de la page d'accueil :
-- un trajet complet (n°2) et un trajet passé (n°5) ne doivent PAS
-- apparaître sur la page d'accueil.
-- ----------------------------------------------------------------------
INSERT INTO trajet (agence_depart_id, agence_arrivee_id, date_heure_depart, date_heure_arrivee, nb_places_total, nb_places_dispo, auteur_id) VALUES
    (1, 2,  DATE_ADD(NOW(), INTERVAL 2 DAY),  DATE_ADD(NOW(), INTERVAL 2 DAY) + INTERVAL 4 HOUR, 4, 3, 2),
    (2, 3,  DATE_ADD(NOW(), INTERVAL 1 DAY),  DATE_ADD(NOW(), INTERVAL 1 DAY) + INTERVAL 3 HOUR, 3, 0, 3),
    (4, 5,  DATE_ADD(NOW(), INTERVAL 3 DAY),  DATE_ADD(NOW(), INTERVAL 3 DAY) + INTERVAL 5 HOUR, 4, 4, 4),
    (6, 7,  DATE_ADD(NOW(), INTERVAL 5 DAY),  DATE_ADD(NOW(), INTERVAL 5 DAY) + INTERVAL 6 HOUR, 2, 1, 5),
    (9, 10, DATE_SUB(NOW(), INTERVAL 1 DAY),  DATE_SUB(NOW(), INTERVAL 1 DAY) + INTERVAL 4 HOUR, 4, 2, 6),
    (11, 1, DATE_ADD(NOW(), INTERVAL 4 DAY),  DATE_ADD(NOW(), INTERVAL 4 DAY) + INTERVAL 4 HOUR, 4, 4, 2),
    (12, 8, DATE_ADD(NOW(), INTERVAL 2 DAY),  DATE_ADD(NOW(), INTERVAL 2 DAY) + INTERVAL 3 HOUR, 3, 2, 7);
