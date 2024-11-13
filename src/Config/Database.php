<?php
namespace Config;

class Database {
    // Paramètres de connexion à la base de données
    private string $host = "mysql"; // Assurez-vous que "mysql" correspond à votre nom de service Docker
    private string $dbname = "todo_list_api";
    private string $username = "root";
    private string $password = "root_password";  // Assurez-vous que ce mot de passe est correct dans votre fichier docker-compose.yml
    private ?\PDO $connection = null;

    public function getConnection(): \PDO {
        // Si la connexion n'existe pas encore
        if ($this->connection === null) {
            try {
                // Tentative de connexion à la base de données
                $this->connection = new \PDO(
                    "mysql:host={$this->host};dbname={$this->dbname}",
                    $this->username,
                    $this->password
                );
                // Configuration des options de PDO
                $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                throw new \Exception("Connection error: " . $e->getMessage());
            }
        }
        return $this->connection;
    }
}
