<?php

namespace Controllers;

use Models\TaskModel;

/**
 * Contrôleur pour gérer les opérations sur les tâches.
 */
class TaskController extends AbstractController {
    
    /**
     * Modèle pour interagir avec les données des tâches.
     *
     * @var TaskModel
     */
    private TaskModel $taskModel;

    /**
     * Constructeur pour initialiser le modèle de tâche.
     */
    public function __construct() {
        $this->taskModel = new TaskModel();
    }

    /**
     * Récupère et renvoie toutes les tâches associées à une liste spécifique.
     * Route : GET /lists/{listId}/tasks
     *
     * @param int $listId L'identifiant de la liste.
     * @return void
     */
    public function index(int $listId): void {
        try {
            $tasks = $this->taskModel->findByListId($listId);
            $this->jsonResponse($tasks);
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Crée une nouvelle tâche pour une liste spécifique avec les données fournies.
     * Route : POST /lists/{listId}/tasks
     *
     * @param int $listId L'identifiant de la liste.
     * @return void
     */
    public function create(int $listId): void {
        try {
            $data = $this->getRequestData();

            // Validation des données d'entrée
            if (!isset($data['title'])) {
                $this->errorResponse("Le titre est obligatoire");
                return;
            }

            // Création de la tâche et récupération de son ID
            $id = $this->taskModel->create(
                $listId,
                $data['title'],
                $data['description'] ?? null
            );

            // Réponse de succès
            $this->jsonResponse([
                'message' => 'Tâche créée avec succès',
                'id' => $id
            ], 201);

        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 500);
        }
    }
}
