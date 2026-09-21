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

## État actuel

- [x] Connexion à la base (PDO singleton)
- [x] Page d'accueil (liste des trajets disponibles)
- [x] Authentification (connexion / déconnexion)
- [ ] Création / modification / suppression de trajet
- [ ] Tableau de bord admin (agences, utilisateurs, trajets)
- [ ] Tests PHPUnit
- [x] Compilation Sass + palette de couleurs imposée
- [ ] Vérification PHPStan

## Architecture

MVC maison : `src/Controller`, `src/Model`, `src/Repository`, `src/Core`.
Routage via [iznburak/php-router](https://packagist.org/packages/iznburak/router).
