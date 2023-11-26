<?php

namespace Tioss\core;
use PDO;
use Tioss\core\Application;
use Tioss\migrations\m0001_initial;
use Tioss\migrations\m0002_products;
use Tioss\migrations\m0003_sellers;

class Database
{
    public \PDO $pdo;
    public static Database $db;


    public function __construct(array $config)
    {
        self::$db = $this;
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        $this->pdo->setAttribute( \PDO::ATTR_TIMEOUT, 30);
    }

    public function applyMigration()
    {
        $this->createMigrationTable();
        $appliedMigration = $this->getAppliedMigration();

        $newMigration = [];
        $files = scandir(Application::$ROOT_DIR."/migrations");
        $file = Application::$ROOT_DIR."/migrations";
        $toapplyMigration = array_diff($files, $appliedMigration);
        
        foreach($toapplyMigration as $migration)
        {

            if($migration === '.' || $migration === '..')
            {
                continue;
            }
            require_once $file.'/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");

            $newMigration[] = $migration;

        }

        if(!empty($newMigration))
        {
            $this->saveMigration($newMigration);
        } else
        {
            $this->log("All migrations are applied");
        }
    }

    public function createMigrationTable()
    {
        $this->pdo->exec(' CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )');
    }

    public function getAppliedMigration()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM  migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigration(array $migration)
    {
        $str = implode(",", array_map(fn($m) => "('$m')", $migration));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration)
                            VALUES  $str
                            
        ");
        $statement->execute();
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    protected function log($message)
    {
        echo '['.date('Y-m-d H:i:s').'] - ' .$message.PHP_EOL;
    }
}