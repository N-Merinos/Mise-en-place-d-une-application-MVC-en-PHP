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
   **Sous PowerShell**, `<` n'est pas supporté pour rediriger un fichier, et
   `Get-Content | mysql` corrompt les caractères accentués (encodage par
   défaut de PowerShell différent d'UTF-8). Utiliser à la place :
   ```
   cmd /c "mysql -u root --default-character-set=utf8mb4 < database\schema.sql"
   cmd /c "mysql -u root --default-character-set=utf8mb4 < database\seed.sql"
   ```
   (délègue la redirection à `cmd.exe`, qui transfère le fichier tel quel,
   sans repasser par l'encodage texte de PowerShell — le terminal intégré
   de Laragon, qui est déjà un `cmd`, accepte directement la première forme)
3. Copier `config/config.php` et adapter les identifiants MySQL si besoin
   (par défaut : `root` sans mot de passe, ce qui correspond à l'installation
   par défaut de Laragon)
4. `npm install` puis `npm run build` (compile le Sass avec la palette
   imposée dans `public/assets/css/main.css`, et copie le JS de Bootstrap
   nécessaire aux fenêtres modales dans `public/assets/js/`)
5. Lancer le serveur local, **depuis le dossier du projet** :
   `php -S localhost:8000 -t public`
6. Ouvrir `http://localhost:8000`

En développement, `npm run watch:css` recompile automatiquement à chaque modification des fichiers `.scss`.

## Tests et qualité de code

Les tests couvrent les opérations d'écriture (création, modification, suppression de trajets et d'agences), dans une base séparée pour ne jamais toucher aux données réelles.

1. Créer la base de test :
   ```
   mysql -u root < database/schema-test.sql
   ```
   (sous PowerShell : `cmd /c "mysql -u root --default-character-set=utf8mb4 < database\schema-test.sql"`, voir la remarque sur l'encodage ci-dessus)
2. Lancer les tests : `vendor\bin\phpunit`
3. Analyse statique : `vendor\bin\phpstan analyse`

Chaque test s'exécute dans une transaction annulée à la fin (rollback), donc la base de test reste toujours vide entre deux exécutions.

## Comptes de test

Le mot de passe `password123` est appliqué à tous les employés (l'annexe RH ne fournissant pas de mot de passe). Le compte admin n'est pas issu de l'annexe (aucun employé n'y est désigné comme tel) : il est ajouté séparément dans `seed.sql`.

| Rôle    | Email               | Mot de passe |
|---------|---------------------|--------------|
| Admin   | admin@klaxon.fr     | password123  |
| Employé | alexandre.martin@email.fr | password123 |

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
