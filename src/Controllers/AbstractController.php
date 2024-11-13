<?php

namespace Controllers;

/**
 * Classe abstraite pour les contrôleurs, fournissant des méthodes utilitaires 
 * pour gérer les réponses JSON, les erreurs, et les données de requêtes.
 */
abstract class AbstractController {

    /**
     * Envoie une réponse JSON avec un code de statut HTTP.
     *
     * @param mixed $data Les données à inclure dans la réponse JSON.
     * @param int $statusCode Le code de statut HTTP (par défaut : 200).
     * @return void
     */
    protected function jsonResponse($data, int $statusCode = 200): void {
        http_response_code($statusCode);
        echo json_encode($data);
    }

    /**
     * Récupère et décode les données JSON envoyées dans le corps de la requête.
     *
     * @return array|null Les données de la requête sous forme de tableau associatif,
     *                    ou null si le corps de la requête est vide ou invalide.
     */
    protected function getRequestData(): ?array {
        return json_decode(file_get_contents('php://input'), true);
    }

    /**
     * Envoie une réponse d'erreur JSON avec un message et un code de statut HTTP.
     *
     * @param string $message Le message d'erreur.
     * @param int $statusCode Le code de statut HTTP pour l'erreur (par défaut : 400).
     * @return void
     */
    protected function errorResponse(string $message, int $statusCode = 400): void {
        $this->jsonResponse(['error' => $message], $statusCode);
    }
}
