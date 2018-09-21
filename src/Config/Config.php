<?php


namespace App\Config;


class Config
{
    static public $environment = 'dev';
    static private $db;

    /**
     * @return \PDO
     */
    static public function getDb()
    {
        if (is_null(self::$db)) {
            self::$db = new \PDO(self::getDbPath());
            self::$db->exec("CREATE TABLE IF NOT EXISTS task (
                    id INTEGER PRIMARY KEY, 
                    userName TEXT, 
                    email TEXT, 
                    text TEXT,
                    imagePath TEXT,
                    executed BOOLEAN)");
        }

        return self::$db;
    }

    static public function clearDb()
    {
        $db = self::getDb();
        $db->exec("delete from task");
    }

    static public function getDbPath()
    {
        $dirDB = __DIR__.'/../../data';
        switch (self::$environment) {
            case 'prod':
                $dbPath = 'sqlite:'.$dirDB.'/tasks.sqlite3';
                break;
            case 'dev':
                $dbPath = 'sqlite:'.$dirDB.'/tasks_dev.sqlite3';
                break;
            default:
                $dbPath = 'sqlite:'.$dirDB.'/tasks_test.sqlite3';
                break;
        }

        return $dbPath;
    }
}
