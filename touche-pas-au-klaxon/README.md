# Touche pas au klaxon

Application de covoiturage inter-sites — DWWM, CEF.

## Installation

1. `composer install`
2. Créer la base : `mysql -u root -p < database/schema.sql`
3. Charger le jeu de données : `mysql -u root -p < database/seed.sql`
4. Copier `config/config.php` et adapter les identifiants MySQL
5. `npm install` puis `npm run build:css` (compile le Sass avec la palette imposée dans `public/assets/css/main.css`)
6. Lancer le serveur local : `php -S localhost:8000 -t public`
7. Ouvrir `http://localhost:8000`

En développement, `npm run watch:css` recompile automatiquement à chaque modification des fichiers `.scss`.

## Comptes de test

| Rôle    | Email               | Mot de passe |
|---------|---------------------|--------------|
| Admin   | admin@klaxon.fr     | password123  |
| Employé | julie.dupont@klaxon.fr | password123 |

## Tests

Les tests couvrent les opérations d'écriture (création, modification, suppression de trajets et d'agences), dans une base séparée pour ne jamais toucher aux données réelles.

1. Créer la base de test : `mysql -u root -p < database/schema-test.sql`
2. Lancer les tests : `vendor/bin/phpunit`

Chaque test s'exécute dans une transaction annulée à la fin (rollback), donc la base de test reste toujours vide entre deux exécutions — pas besoin de la recréer à chaque fois.

## État actuel

- [x] Connexion à la base (PDO singleton)
- [x] Page d'accueil (liste des trajets disponibles)
- [x] Authentification (connexion / déconnexion)
- [x] Création / modification / suppression de trajet
- [x] Tableau de bord admin (agences, utilisateurs, trajets)
- [x] Tests PHPUnit
- [x] Compilation Sass + palette de couleurs imposée
- [ ] Vérification PHPStan

## Architecture

MVC maison : `src/Controller`, `src/Model`, `src/Repository`, `src/Core`.
Routage via [iznburak/php-router](https://packagist.org/packages/iznburak/router).
