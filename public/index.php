<?php

// Inclut le fichier de connexion à la base de données
require_once '../src/Config/Database.php';

/**
 * Point d'entrée de l'API REST.
 *
 * Ce fichier est responsable de la gestion des requêtes HTTP et de la réponse
 * sous forme de JSON. Il vérifie d'abord si l'API fonctionne et renvoie un message
 * de test. Plus tard, ce fichier gérera le routage des différentes requêtes.
 */

// Indique que la réponse sera au format JSON
header('Content-Type: application/json');

try {
    // Test simple pour vérifier que l'API fonctionne
    echo json_encode(['status' => 'API is running']);
} catch (Exception $e) {
    // En cas d'erreur, renvoie un code 500 et le message d'erreur
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
