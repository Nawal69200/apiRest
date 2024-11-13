<?php
// Inclut le fichier de connexion à la base
require_once '../src/Config/Database.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Indique que la réponse sera en JSON
header('Content-Type: application/json');

try {
    // Initialise la connexion à la base de données
    $database = new Config\Database();
    $connection = $database->getConnection();

    // Test simple pour vérifier que l'API fonctionne et que la base est connectée
    echo json_encode(['status' => 'API is running', 'database' => 'connected']);
} catch (Exception $e) {
    // En cas d'erreur, renvoie un code 500 et le message d'erreur
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}
