<?php

namespace App\Controller;

use App\Core\Database;

class AuthController
{
    public function showLoginForm(): void
    {
        require __DIR__ . '/../../views/auth/login.php';
    }

    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $motDePasse = $_POST['mot_de_passe'] ?? '';

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM employe WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $employe = $stmt->fetch();

        if (!$employe || !password_verify($motDePasse, $employe['mot_de_passe'])) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Identifiants invalides.'];
            header('Location: /connexion');
            exit;
        }

        $_SESSION['user'] = [
            'id'      => $employe['id'],
            'nom'     => $employe['nom'],
            'prenom'  => $employe['prenom'],
            'email'   => $employe['email'],
            'role'    => $employe['role'],
        ];

        header('Location: /');
        exit;
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}
