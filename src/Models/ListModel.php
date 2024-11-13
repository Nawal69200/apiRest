<?php
namespace Models;

require_once '../src/Models/AbstractModel.php';

class ListModel extends AbstractModel {
    protected string $table = "lists";

    // Méthode pour créer une nouvelle liste
    public function create(string $title, ?string $description = null): int {
        $query = "INSERT INTO {$this->table} (title, description) VALUES (:title, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'title' => $this->sanitize($title),
            'description' => $description ? $this->sanitize($description) : null
        ]);
        return (int)$this->db->lastInsertId();
    }

    // Récupère toutes les listes
    public function findAll(): array {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        return $this->db->query($query)->fetchAll();
    }
}
