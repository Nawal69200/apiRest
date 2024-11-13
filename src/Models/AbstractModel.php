<?php

namespace Models;

/**
 * Classe abstraite pour les Models permettant de centraliser les opérations communes.
 * Cette classe contient des méthodes génériques pour la gestion des données, telles que 
 * la connexion à la base de données, la recherche par ID et la suppression.
 * Elle sert de base pour tous les autres modèles de l'application.
 *
 * @package Models
 */
abstract class AbstractModel {
    
    /**
     * Instance de la connexion à la base de données.
     *
     * @var \PDO
     */
    protected \PDO $db;

    /**
     * Nom de la table associée au modèle.
     *
     * @var string
     */
    protected string $table;

    /**
     * Constructeur de la classe.
     * Initialise la connexion à la base de données en utilisant la configuration.
     */
    public function __construct() {
        $database = new \Config\Database();
        $this->db = $database->getConnection();
    }

    /**
     * Méthode pour nettoyer les entrées avant de les utiliser.
     * Évite les injections XSS et les balises HTML non désirées.
     * 
     * @param string $value La valeur à nettoyer.
     * @return string La valeur nettoyée.
     */
    protected function sanitize(string $value): string {
        return htmlspecialchars(strip_tags($value));
    }

    /**
     * Trouve une entrée par son ID dans la table associée.
     * 
     * @param int $id L'ID de l'entrée à rechercher.
     * @return array|null Retourne un tableau associatif de l'entrée ou null si elle n'existe pas.
     */
    public function findById(int $id): ?array {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Supprime une entrée par son ID dans la table associée.
     * 
     * @param int $id L'ID de l'entrée à supprimer.
     * @return bool Retourne true si la suppression a réussi, sinon false.
     */
    public function delete(int $id): bool {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
