<?php
require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\User;
use App\Users;

session_start();

$pdo = (new SQLiteConnection())->connect();
if ($pdo == null) {
    exit("Could not connect to the SQLite database!");
}

if (isset($_REQUEST['id'])) {
    $user = new User($pdo);
    $user->lookupById($_REQUEST['id']);
    $profileName = $user->getUsername();
}

if (!isset($profileName)) {
    $profileName = 'Unknown User';
}

$subtitle = "User Profile: $profileName";
include("header.php");

// Login or Logout button
echo '<div class="button">';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '<a href="logout.php">Logout</a>';
} else {
    echo '<a href="login.php">Login</a>';
}
echo '</div>';

if ($profileName == 'Unknown User') {
    echo "<p>Either no user was specified, or the specified user does not exist.</p>";
} else {
    echo "<strong>" . $user->getUsername() . "</strong>";
    echo "<div>FooCoin balance: " . $user->getCoinCount() . "</div>";
}

include("footer.php");
