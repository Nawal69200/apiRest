<?php

namespace Config;

/**
 * Classe permettant de gérer la connexion à la base de données.
 *
 * Cette classe utilise le pattern Singleton pour s'assurer qu'une seule connexion
 * à la base de données existe pendant l'exécution de l'application.
 *
 * @package Config
 */
class Database
{
    /**
     * Hôte de la base de données.
     * 
     * @var string
     */
    private string $host = "localhost";

    /**
     * Nom de la base de données.
     *
     * @var string
     */
    private string $dbname = "todo_list_api";

    /**
     * Nom d'utilisateur pour la connexion à la base de données.
     *
     * @var string
     */
    private string $username = "root";

    /**
     * Mot de passe pour la connexion à la base de données.
     *
     * @var string
     */
    private string $password = "root_password";

    /**
     * Instance de la connexion PDO.
     * 
     * @var \PDO|null
     */
    private ?\PDO $connection = null;

    /**
     * Retourne une instance de la connexion PDO.
     * Si la connexion n'existe pas, elle est créée.
     *
     * @return \PDO La connexion PDO.
     * @throws \Exception Si la connexion échoue.
     */
    public function getConnection(): \PDO
    {
        // Si la connexion n'existe pas encore
        if ($this->connection === null) {
            try {
                // Tentative de connexion à la base de données
                $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
                $this->connection = new \PDO($dsn, $this->username, $this->password);
                
                // Définir le mode de gestion des erreurs de PDO
                $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                // En cas d'erreur, on lance une exception avec le message d'erreur
                throw new \Exception("Connection error: " . $e->getMessage());
            }
        }

        // Retourne la connexion établie
        return $this->connection;
    }
}
