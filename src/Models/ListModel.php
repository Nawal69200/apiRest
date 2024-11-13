<?php
namespace Models;

require_once '../src/Models/AbstractModel.php';

/**
 * Classe permettant de gérer les listes de tâches dans la base de données.
 * Hérite de AbstractModel pour partager les fonctionnalités communes.
 *
 * @package Models
 */
class ListModel extends AbstractModel {
    
    /**
     * @var string Nom de la table 'lists' pour ce modèle
     */
    protected string $table = "lists";

    /**
     * Crée une nouvelle liste.
     * 
     * @param string $title Titre de la liste.
     * @param string|null $description Description optionnelle de la liste.
     * @return int L'ID de la nouvelle liste.
     */
    public function create(string $title, ?string $description = null): int {
        $query = "INSERT INTO {$this->table} (title, description) VALUES (:title, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'title' => $this->sanitize($title),
            'description' => $description ? $this->sanitize($description) : null
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Récupère toutes les listes.
     * 
     * @return array Liste des listes de tâches.
     */
    public function findAll(): array {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        return $this->db->query($query)->fetchAll();
    }
}
