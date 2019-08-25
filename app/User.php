<?php

namespace App;

class User {

    private $pdo;
    private $id;
    private $username;
    private $password;
    private $coin_count;

    /**
    * assign database connection
    */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function lookupById($id) {
        $stmt = $this->pdo->query('SELECT id, username, password, coin_count
                                    FROM user
                                    WHERE id = ' . $id);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->coin_count = $row['coin_count'];
        }
    }

    public function lookupByUsername($username) {
        $sql = "SELECT id, username, password, coin_count FROM user WHERE username = '" . $username . "'";
        $stmt = $this->pdo->query($sql);
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->coin_count = $row['coin_count'];
        }
    }

    public function isValidPassword($password) {
        return true;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getCoinCount() {
        return $this->coin_count;
    }

    public function addCoins($n) {
        $stmt = $this->pdo->prepare('UPDATE user SET coin_count = ' . $this->coin_count + $n . ' WHERE id = ' . $this.id);
        $stmt->execute();
    }

    public function substractCoins($n) {
        $stmt = $this->pdo->prepare('UPDATE user SET coin_count = ' . $this->coin_count - $n . ' WHERE id = ' . $this.id);
        $stmt->execute();
    }

    public function transferCoins($n, $id) {
        // create a user object for the target of transfer
        $targetUser = (new User($this->pdo))->lookupById($id);

        // subtract coins from wallet
        $this->subtractCoins($n);

        // add coins to target user's wallet
        $this->addCoins($n);
    }

}
