<?php
// Test des modèles ListModel et TaskModel
require_once '../src/Config/Database.php';
require_once '../src/Models/ListModel.php';
require_once '../src/Models/TaskModel.php';

// Tester la création d'une liste
$listModel = new \Models\ListModel();
$listId = $listModel->create("Courses", "Liste des courses");
$list = $listModel->findById($listId);
var_dump($list);

// Tester la création de tâches
$taskModel = new \Models\TaskModel();
$taskId = $taskModel->create($listId, "Pain", "Acheter du pain");
$tasks = $taskModel->findByListId($listId);
var_dump($tasks);
?>
