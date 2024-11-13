<?php
namespace Config;

class Router {
    // Tableau pour stocker les routes
    private array $routes = [];

    /**
     * Ajoute une route au routeur.
     *
     * @param string $method     Méthode HTTP (GET, POST, etc.)
     * @param string $path       Chemin de la route, avec des paramètres dynamiques (ex: /user/{id:int})
     * @param string $controller Nom du contrôleur à appeler
     * @param string $action     Nom de la méthode dans le contrôleur
     */
    public function addRoute(string $method, string $path, string $controller, string $action): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    /**
     * Gère la requête en cherchant la route appropriée dans le tableau $routes.
     * Si une correspondance est trouvée, elle crée le contrôleur et appelle l'action avec les paramètres.
     * En cas d'absence de correspondance, elle renvoie une erreur 404.
     *
     * @param string $method Méthode HTTP de la requête (ex: GET, POST)
     * @param string $uri    URI demandée
     */
    public function handleRequest(string $method, string $uri): void {
        // Nettoie l'URI pour obtenir le chemin sans slashes de début ou fin
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');
        
        // Parcourt chaque route pour trouver une correspondance
        foreach ($this->routes as $route) {
            // Continue si la méthode HTTP ne correspond pas
            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            // Transforme le chemin en expression régulière pour capturer les paramètres
            $pattern = preg_replace_callback('/\{(\w+):(\w+)?\}/', function($matches) {
                $param = $matches[1]; // Nom du paramètre
                $type = $matches[2] ?? 'int'; // Type de paramètre, par défaut 'int'
                
                // Définit les expressions régulières pour chaque type de paramètre
                return match($type) {
                    'int' => '(\d+)',          // Nombres
                    'str' => '(\w+)',          // Chaînes de caractères alphanumériques
                    'any' => '(.+)',           // Chaînes libres
                    default => '(\d+)'         // Par défaut, accepte les entiers
                };
            }, $route['path']);

            // Ajoute des délimiteurs à l'expression régulière
            $pattern = "@^" . str_replace('/', '\/', $pattern) . "$@D";

            // Vérifie si l'URI correspond au pattern
            if (preg_match($pattern, $uri, $matches)) {
                // Supprime le premier élément du tableau (correspondance complète)
                array_shift($matches);
                
                // Crée une instance du contrôleur et appelle l'action
                $controllerName = "Controllers\\" . $route['controller'];
                if (class_exists($controllerName) && method_exists($controllerName, $route['action'])) {
                    $controller = new $controllerName();
                    call_user_func_array([$controller, $route['action']], $matches);
                } else {
                    // Renvoie une erreur 500 si le contrôleur ou l'action n'existe pas
                    $this->sendError(500, 'Contrôleur ou action introuvable.');
                }
                return; // Fin du traitement si une route correspond
            }
        }
        
        // Si aucune route ne correspond, renvoie une erreur 404
        $this->sendError(404, 'Route non trouvée');
    }

    /**
     * Gère l'envoi d'une réponse d'erreur avec un code HTTP et un message JSON.
     *
     * @param int $statusCode Code HTTP de l'erreur
     * @param string $message Message d'erreur
     */
    private function sendError(int $statusCode, string $message): void {
        http_response_code($statusCode);
        echo json_encode(['error' => $message]);
    }
}
