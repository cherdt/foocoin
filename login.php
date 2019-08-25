<?php
require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\User;

session_start();
$subtitle = "Login";
include("header.php");

// If username and password were submitted, try to log in the user
if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    $user = new User((new SQLiteConnection())->connect());
    $user->lookupByUsername($_REQUEST['username']);
    if ($user->isValidPassword($_REQUEST['password']) == true) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_REQUEST['username'];
    } else {
        echo <<<"EOD"
<p class="alert">Username and/or password were incorrect.</p>
EOD;
    }
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "You are now logged in, " . $_SESSION['username'] . ". You can view your FooCoin wallet and transfer coins on the <a href=\"index.php\">main page</a>.";
} else {
    echo <<<"EOD"
<h1>Login</h1>
<form action="login.php" method="POST">
    <label>Username <input type="text" name="username" value=""></label>
    <label>Password <input type="password" name="password" value=""></label>
    <input type="submit" value="Login">
</form>
EOD;
}

include("footer.php");
