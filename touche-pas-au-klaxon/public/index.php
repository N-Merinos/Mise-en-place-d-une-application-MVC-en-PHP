<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\TrajetController;
use App\Controller\AdminController;
use App\Core\Router;

$router = new Router();

// -- Public --------------------------------------------------------------
$router->get('/', [HomeController::class, 'index']);
$router->get('/connexion', [AuthController::class, 'showLoginForm']);
$router->post('/connexion', [AuthController::class, 'login']);
$router->get('/deconnexion', [AuthController::class, 'logout']);

// -- Employé connecté ------------------------------------------------------
$router->get('/trajet/creer', [TrajetController::class, 'create']);
$router->post('/trajet/creer', [TrajetController::class, 'store']);
$router->get('/trajet/{id}/modifier', [TrajetController::class, 'edit']);
$router->post('/trajet/{id}/modifier', [TrajetController::class, 'update']);
$router->post('/trajet/{id}/supprimer', [TrajetController::class, 'delete']);

// -- Admin -----------------------------------------------------------------
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/agences', [AdminController::class, 'listAgences']);
$router->post('/admin/agences/creer', [AdminController::class, 'createAgence']);
$router->post('/admin/agences/{id}/modifier', [AdminController::class, 'updateAgence']);
$router->post('/admin/agences/{id}/supprimer', [AdminController::class, 'deleteAgence']);
$router->get('/admin/utilisateurs', [AdminController::class, 'listUtilisateurs']);
$router->get('/admin/trajets', [AdminController::class, 'listTrajets']);
$router->post('/admin/trajets/{id}/supprimer', [AdminController::class, 'deleteTrajet']);

$router->run();
