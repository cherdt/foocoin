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
        #return md5($password) == $this->password;
        #return true;
        return $password == $this->password;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getCoinCount() {
        return $this->coin_count;
    }

    public function addCoins($n) {
        $sql = 'UPDATE user SET coin_count = ' . ($this->coin_count + $n) . ' WHERE id = ' . $this->id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function subtractCoins($n) {
        $sql = 'UPDATE user SET coin_count = ' . ($this->coin_count - $n) . ' WHERE id = ' . $this->id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function transferCoins($n, $id) {
        // check to make sure n is a number
        if (is_numeric($n)) {
            $n = (int)$n;
        } else {
            exit("Coin amount must be an integer value.");
        }

        $id = (int)$id;

        // create a user object for the target of transfer
        $targetUser = (new User($this->pdo));
        $targetUser->lookupById($id);

        // subtract coins from wallet
        $this->subtractCoins($n);

        // add coins to target user's wallet
        $targetUser->addCoins($n);
    }

}
