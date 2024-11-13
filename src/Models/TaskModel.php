<?php
namespace Models;

require_once '../src/Models/AbstractModel.php';

/**
 * Classe permettant de gérer les tâches dans la base de données.
 * Hérite de AbstractModel pour partager les fonctionnalités communes.
 *
 * @package Models
 */
class TaskModel extends AbstractModel {
    
    /**
     * @var string Nom de la table 'tasks' pour ce modèle
     */
    protected string $table = "tasks";

    /**
     * Crée une nouvelle tâche dans une liste donnée.
     * 
     * @param int $listId L'ID de la liste associée à la tâche.
     * @param string $title Titre de la tâche.
     * @param string|null $description Description optionnelle de la tâche.
     * @return int L'ID de la nouvelle tâche.
     */
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

    /**
     * Trouve toutes les tâches d'une liste donnée.
     * 
     * @param int $listId L'ID de la liste.
     * @return array Liste des tâches.
     */
    public function findByListId(int $listId): array {
        $query = "SELECT * FROM {$this->table} WHERE list_id = :list_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['list_id' => $listId]);
        return $stmt->fetchAll();
    }
}
