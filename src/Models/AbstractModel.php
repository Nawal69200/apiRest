<?php
namespace Models;

/**
 * Classe abstraite pour les Models permettant de centraliser les opérations communes.
 * Cette classe contient des méthodes pour la gestion des données communes comme 
 * la connexion, la recherche par ID et la suppression.
 *
 * @package Models
 */
abstract class AbstractModel {
    
    /**
     * @var \PDO Instance de la connexion à la base de données
     */
    protected \PDO $db;

    /**
     * @var string Nom de la table associée au modèle
     */
    protected string $table;

    /**
     * Constructeur qui initialise la connexion à la base de données.
     */
    public function __construct() {
        $database = new \Config\Database();
        $this->db = $database->getConnection();
    }

    /**
     * Méthode pour nettoyer les entrées avant de les utiliser.
     * 
     * @param string $value La valeur à nettoyer.
     * @return string La valeur nettoyée.
     */
    protected function sanitize(string $value): string {
        return htmlspecialchars(strip_tags($value));
    }

    /**
     * Trouve une entrée par son ID.
     * 
     * @param int $id L'ID de l'entrée.
     * @return array|null Retourne l'entrée ou null si elle n'existe pas.
     */
    public function findById(int $id): ?array {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Supprime une entrée par son ID.
     * 
     * @param int $id L'ID de l'entrée.
     * @return bool Retourne true si la suppression a réussi.
     */
    public function delete(int $id): bool {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
