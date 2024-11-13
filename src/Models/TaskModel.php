<?php

namespace Models;

require_once '../src/Models/AbstractModel.php';

/**
 * Classe permettant de gérer les tâches dans la base de données.
 * Hérite de AbstractModel pour partager les fonctionnalités communes.
 *
 * Cette classe est utilisée pour créer, lire et gérer les données 
 * liées aux tâches de chaque liste.
 *
 * @package Models
 */
class TaskModel extends AbstractModel {
    
    /**
     * Nom de la table 'tasks' pour ce modèle.
     *
     * @var string
     */
    protected string $table = "tasks";

    /**
     * Crée une nouvelle tâche dans une liste donnée.
     * 
     * Cette méthode permet d'ajouter une tâche à une liste spécifique 
     * en utilisant l'ID de la liste et le titre de la tâche. 
     * Une description optionnelle peut également être ajoutée.
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
     * Cette méthode renvoie toutes les tâches associées à une liste
     * spécifique en utilisant l'ID de la liste.
     *
     * @param int $listId L'ID de la liste.
     * @return array Liste des tâches, chaque tâche étant un tableau associatif.
     */
    public function findByListId(int $listId): array {
        $query = "SELECT * FROM {$this->table} WHERE list_id = :list_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['list_id' => $listId]);
        return $stmt->fetchAll();
    }
}
