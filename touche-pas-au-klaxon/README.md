# Touche pas au klaxon

Application de covoiturage inter-sites — DWWM, CEF.

## Installation

**Prérequis** : PHP 8.1+, MySQL/MariaDB, Composer et Node.js/npm. Sous Windows,
[Laragon](https://laragon.org/download/) (version "Full") fournit PHP, MySQL et
un terminal préconfiguré en une seule installation — c'est ce qui a été utilisé
pour développer et tester ce projet.

> **Windows / Laragon** : lance Laragon en tant qu'administrateur (clic droit →
> "Exécuter en tant qu'administrateur"), sinon `npm install` et certaines
> commandes MySQL échouent avec une erreur de permissions (`EPERM`). Utilise le
> terminal intégré de Laragon (bouton "Terminal") plutôt que celui de VS Code
> par défaut : PHP et MySQL n'y sont pas forcément dans le PATH système sinon.

1. `composer install`
2. Créer la base et charger le jeu de données :
   ```
   mysql -u root < database/schema.sql
   mysql -u root < database/seed.sql
   ```
   (sous PowerShell, remplacer `mysql -u root < fichier.sql` par
   `Get-Content fichier.sql | mysql -u root` — PowerShell ne supporte pas `<`
   pour rediriger un fichier ; le terminal Laragon, lui, l'accepte directement)
3. Copier `config/config.php` et adapter les identifiants MySQL si besoin
   (par défaut : `root` sans mot de passe, ce qui correspond à l'installation
   par défaut de Laragon)
4. `npm install` puis `npm run build:css` (compile le Sass avec la palette
   imposée dans `public/assets/css/main.css`)
5. Lancer le serveur local, **depuis le dossier du projet** :
   `php -S localhost:8000 -t public`
6. Ouvrir `http://localhost:8000`

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
- [x] Création / modification / suppression de trajet
- [x] Tableau de bord admin (agences, utilisateurs, trajets)
- [x] Tests PHPUnit
- [x] Compilation Sass + palette de couleurs imposée
- [x] Vérification PHPStan

## Architecture

MVC maison : `src/Controller`, `src/Model`, `src/Repository`, `src/Core`.
Routage via un routeur maison (`src/Core/Router.php`) — la librairie
initialement prévue ([iznburak/router](https://packagist.org/packages/iznburak/router))
a une API basée sur des objets Request/Response incompatible avec
l'architecture des contrôleurs de ce projet ; voir la PR
"Remplacement de la dépendance iznburak/router" pour le détail.
