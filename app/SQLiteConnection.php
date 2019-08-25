<?php

namespace App;

class SQLiteConnection {

    /**
    * PDO object
    * @var \PDO
    */
    private $pdo;


    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect() {
        if ($this->pdo == null) {
            $this->pdo = new \PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
        }
        return $this->pdo;
    }


    public function initDB() {
        $this->connect();
        $this->createTables();
        $this->insertUsers();
    }

    private function createTables() {
        $commands = ['CREATE TABLE IF NOT EXISTS user (
                        id INTEGER PRIMARY KEY,
                        username TEXT NOT NULL UNIQUE,
                        password TEXT,
                        coin_count INTEGER
                    )'];

        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }

    private function insertUsers() {

#        $users = [];
        $users = array(array("username"=>"alice", "password"=>"123456", "coin_count"=>1000),
                array("username"=>"bob", "password"=>"123456", "coin_count"=>1000),
                array("username"=>"eve", "password"=>"123456", "coin_count"=>1000),
                array("username"=>"mallory", "password"=>"123456", "coin_count"=>1000),
                array("username"=>"student", "password"=>"123456", "coin_count"=>1000));

        foreach ($users as $user) {
            $sql = 'INSERT INTO user (username, password, coin_count) VALUES (:username, :password, :coin_count);';
            $stmt = $this->pdo->prepare($sql);
            var_dump($stmt);
            $stmt->bindValue(':username', $user["username"]);
            $stmt->bindValue(':password', $user["password"]);
            $stmt->bindValue(':coin_count', $user["coin_count"]);

            $stmt->execute();
        }
    }

}
