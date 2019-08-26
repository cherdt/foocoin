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
                        status TEXT,
                        coin_count INTEGER
                    )'];

        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }

    private function insertUsers() {

#        $users = [];
        $users = array(array("username"=>"alice", "password"=>"d8578edf8458ce06fbc5bb76a58c5ca4", "status"=>"Have you seen a rabbit with a pocketwatch?", "coin_count"=>24000),
                array("username"=>"bob", "password"=>"5f4dcc3b5aa765d61d8327deb882cf99", "status"=>"I'd rather be lucky than good!", "coin_count"=>18000),
                array("username"=>"eve", "password"=>"2ab96390c7dbe3439de74d0c9b0b1767", "status"=>"How about them apples?", "coin_count"=>9987),
                array("username"=>"mallory", "password"=>"8621ffdbc5698829397d97767ac13db3", "status"=>"What hath night to do with sleep?", "coin_count"=>31337),
                array("username"=>"student", "password"=>"e10adc3949ba59abbe56e057f20f883e", "status"=>"Here to learn!", "coin_count"=>1000));

        foreach ($users as $user) {
            $sql = 'INSERT INTO user (username, password, status, coin_count) VALUES (:username, :password, :status, :coin_count);';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':username', $user["username"]);
            $stmt->bindValue(':password', $user["password"]);
            $stmt->bindValue(':status', $user["status"]);
            $stmt->bindValue(':coin_count', $user["coin_count"]);

            $stmt->execute();
        }
    }

}
