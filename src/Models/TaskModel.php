<?php
namespace Models;

require_once '../src/Models/AbstractModel.php';

class TaskModel extends AbstractModel {
    protected string $table = "tasks";

    // Méthode pour créer une nouvelle tâche
    public function create(int $listId, string $title, ?string $description = null): int {
        $query = "INSERT INTO {$this->table} (list_id, title, description) VALUES (:list_id, :title, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'list_id' => $listId,
            'title' => $this->sanitize($title),
            'description' => $description ? $this->sanitize($description) : null
        ]);
        return (int)$this->db->lastInsertId();
    }

    // Récupère toutes les tâches d'une liste donnée
    public function findByListId(int $listId): array {
        $query = "SELECT * FROM {$this->table} WHERE list_id = :list_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['list_id' => $listId]);
        return $stmt->fetchAll();
    }
}
