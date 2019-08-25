<?php

namespace App;

class Users {

    private $pdo;
    private $users;

    /**
    * assign database connection
    */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUsers() {
        $sql = 'SELECT id, username, coin_count FROM user';
        $stmt = $this->pdo->query($sql);

        $this->users = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->users[] = [
                'id' => $row['id'],
                'username' => $row['username'],
                'coin_count' => $row['coin_count']
            ];
        }
        return $this->users;
    }

}
