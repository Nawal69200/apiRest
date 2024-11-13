<?php
namespace Models;

abstract class AbstractModel {
    protected \PDO $db;
    protected string $table;

    // Constructeur, connexion à la base de données
    public function __construct() {
        $database = new \Config\Database();
        $this->db = $database->getConnection();
    }

    // Méthode pour nettoyer les entrées (sécurisation)
    protected function sanitize(string $value): string {
        return htmlspecialchars(strip_tags($value));
    }

    // Méthode commune pour rechercher un enregistrement par ID
    public function findById(int $id): ?array {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    // Méthode pour supprimer un enregistrement
    public function delete(int $id): bool {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
