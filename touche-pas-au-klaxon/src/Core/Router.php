<?php

namespace App\Core;

/**
 * Routeur minimaliste : associe une méthode HTTP + un chemin (avec
 * paramètres {nom}) à une action [Classe::class, 'methode'].
 *
 * Volontairement simple plutôt que d'utiliser une librairie externe :
 * le besoin de ce projet (routes statiques + un paramètre {id} par-ci
 * par-là) ne justifie pas la complexité d'un routeur tiers, et ça évite
 * une dépendance de plus à maintenir.
 */
class Router
{
    /** @var array<string, array<string, array{0: class-string, 1: string}>> */
    private array $routes = [];

    /**
     * @param array{0: class-string, 1: string} $handler
     */
    public function get(string $path, array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    /**
     * @param array{0: class-string, 1: string} $handler
     */
    public function post(string $path, array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    /**
     * @param array{0: class-string, 1: string} $handler
     */
    private function add(string $method, string $path, array $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    /**
     * Résout la requête courante et exécute le contrôleur correspondant.
     * Répond en 404 si aucune route ne correspond.
     */
    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        foreach ($this->routes[$method] ?? [] as $pattern => $handler) {
            $regex = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern);

            if (preg_match('#^' . $regex . '$#', $uri, $matches)) {
                [$class, $methodName] = $handler;

                $params = array_filter(
                    $matches,
                    fn($key) => !is_int($key),
                    ARRAY_FILTER_USE_KEY
                );

                // Les paramètres numériques (ex. {id}) sont castés en int
                // pour correspondre aux signatures des méthodes des contrôleurs.
                $params = array_map(
                    fn($value) => ctype_digit($value) ? (int) $value : $value,
                    $params
                );

                $controller = new $class();
                call_user_func_array([$controller, $methodName], array_values($params));
                return;
            }
        }

        http_response_code(404);
        echo '404 - Page non trouvée';
    }
}
