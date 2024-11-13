<?php
// Dans le fichier public/test.php

require_once '../src/Config/Database.php';
require_once '../src/Models/ListModel.php';
require_once '../src/Models/TaskModel.php';

// Test des listes
$listModel = new \Models\ListModel();
// Crée une nouvelle liste
$listId = $listModel->create("Courses", "Liste des courses");
// Vérifie si la liste a été créée correctement
$list = $listModel->findById($listId);
var_dump($list);
echo '<br/><br/>';

// Test des tâches
$taskModel = new \Models\TaskModel();
// Crée une tâche dans la liste des courses
$taskId = $taskModel->create($listId, "Pain", "Acheter du pain");
// Récupère toutes les tâches de cette liste
$tasks = $taskModel->findByListId($listId);
var_dump($tasks);
