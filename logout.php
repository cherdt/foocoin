<?php
require 'vendor/autoload.php';

// expire session cookie
setcookie("PHPSESSID", "", time() - 3600);
// clear SESSION array
$_SESSION = [];

$subtitle = "Logout";
include("header.php");

echo '<p>You are now logged out. Return to the <a href="index.php">main page</a>';

include("footer.php");
