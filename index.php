<?php
require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\User;
use App\Users;

session_start();
$subtitle = "Main";
include("header.php");

echo '<div class="button">';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '<a href="logout.php">Logout</a>';
} else {
    echo '<a href="login.php">Login</a>';
}
echo '</div>';


$pdo = (new SQLiteConnection())->connect();
if ($pdo == null) {
    exit("Could not connect to the SQLite database!");
}

$users = new Users($pdo);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "<p>Welcome, " . $_SESSION['username'] . "!</p>";

    // Process transfer, if request present
    if (isset($_REQUEST['amount']) && isset($_REQUEST['target_id'])) {
       $user = new User($pdo);
       $user->lookupByUsername($_SESSION['username']);
       $targetUser = new User($pdo);
       $targetUser->lookupById($_REQUEST['target_id']);
       $user->transferCoins($_REQUEST['amount'], $_REQUEST['target_id']); 
       echo '<p class="alert">Successfully transferred ' . $_REQUEST['amount'] . ' FooCoins to ' . $targetUser->getUsername() . '.</p>'; 
    }

    // Transfer Form
    echo "<h2>Transfer FooCoins to another user:</h2>";
    echo '<form action="index.php" method="POST">';
    echo '<label>Transfer <input type="text" name="amount" size="6"> coins</label>';
    echo ' ';
    echo '<label>to user <select name="target_id">';
    foreach ($users->getUsers() as $item) {
        if ($item['username'] != $_SESSION['username']) {
            echo '<option value="' . $item['id'] . '">' . $item['username'] . '</option>';
        }
    }
    echo '</select></label>';
    echo ' ';
    echo '<input type="submit" value="Transfer">';
    echo '</form>';
}

echo "<h2>Top FooCoin Users</h2>";
echo "<table><tr><th>user</th><th>coins</th></tr>";
foreach ($users->getUsers() as $item) {
    echo "<tr><td>" . $item['username'] . "</td><td>" . $item['coin_count'] . "</td>";
}
echo "</table>";

include("footer.php");
