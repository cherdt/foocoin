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
    // If this is the current user's profile, check for status update
    if ($user->getUsername() == $_SESSION['username']) {
        if (isset($_REQUEST['status'])) {
            $user->setStatus($_REQUEST['status']);
        }
    }

    // Display the user's status
    echo "<strong>" . $user->getUsername() . "</strong>";
    echo "<div>Current status message: " . $user->getStatus() . "</div>";
    echo "<div>FooCoin balance: " . $user->getCoinCount() . "</div>";

    // If this is the current user's profile, show status update form
    if ($user->getUsername() == $_SESSION['username']) {
        $id = $user->getId();
        echo <<<"EOD"
        <h3>Update your status message:</h3>
        <p>Let people know what you're thinking!</p>
        <form action="profile.php?id=$id" method="POST">
            <label>Status: <input type="text" name="status" size="80"></label>
            <input type="submit" value="Update Status">
        </form>
EOD;
    }
}

echo '<p><a href="index.php">Back to Main</a></p>';

include("footer.php");
