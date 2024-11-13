<?php

namespace Controllers;

use Models\ListModel;

/**
 * Contrôleur pour gérer les opérations sur les listes.
 */
class ListController extends AbstractController {
    
    /**
     * Modèle pour interagir avec les données des listes.
     *
     * @var ListModel
     */
    private ListModel $listModel;

    /**
     * Constructeur pour initialiser le modèle de liste.
     */
    public function __construct() {
        $this->listModel = new ListModel();
    }

    /**
     * Récupère et renvoie toutes les listes.
     * Route : GET /lists
     *
     * @return void
     */
    public function index(): void {
        try {
            $lists = $this->listModel->findAll();
            $this->jsonResponse($lists);
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Récupère et renvoie une liste spécifique par son ID.
     * Route : GET /lists/{id}
     *
     * @param int $id L'identifiant de la liste.
     * @return void
     */
    public function show(int $id): void {
        try {
            $list = $this->listModel->findById($id);
            if (!$list) {
                $this->errorResponse("Liste non trouvée", 404);
                return;
            }
            $this->jsonResponse($list);
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Crée une nouvelle liste avec les données fournies.
     * Route : POST /lists
     *
     * @return void
     */
    public function create(): void {
        try {
            $data = $this->getRequestData();
            
            // Validation des données d'entrée
            if (!isset($data['title'])) {
                $this->errorResponse("Le titre est obligatoire");
                return;
            }

            // Création de la liste et récupération de son ID
            $id = $this->listModel->create(
                $data['title'],
                $data['description'] ?? null
            );

            // Réponse de succès
            $this->jsonResponse([
                'message' => 'Liste créée avec succès',
                'id' => $id
            ], 201);

        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 500);
        }
    }
}
