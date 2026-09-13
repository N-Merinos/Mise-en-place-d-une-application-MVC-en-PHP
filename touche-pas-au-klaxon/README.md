# Touche pas au klaxon

Application de covoiturage inter-sites — DWWM, CEF.

## Installation

1. `composer install`
2. Créer la base : `mysql -u root -p < database/schema.sql`
3. Charger le jeu de données : `mysql -u root -p < database/seed.sql`
4. Copier `config/config.php` et adapter les identifiants MySQL
5. Lancer le serveur local : `php -S localhost:8000 -t public`
6. Ouvrir `http://localhost:8000`

## Comptes de test

| Rôle    | Email               | Mot de passe |
|---------|---------------------|--------------|
| Admin   | admin@klaxon.fr     | password123  |
| Employé | julie.dupont@klaxon.fr | password123 |

## État actuel

- [x] Connexion à la base (PDO singleton)
- [x] Page d'accueil (liste des trajets disponibles)
- [x] Authentification (connexion / déconnexion)
- [x] Création / modification / suppression de trajet
- [x] Tableau de bord admin (agences, utilisateurs, trajets)
- [ ] Tests PHPUnit
- [ ] Compilation Sass + palette de couleurs imposée
- [ ] Vérification PHPStan

## Architecture

MVC maison : `src/Controller`, `src/Model`, `src/Repository`, `src/Core`.
Routage via [iznburak/php-router](https://packagist.org/packages/iznburak/router).
