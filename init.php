<?php
require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\User;
#use App\SQLiteCreateTable;
#use App\SQLiteInsert;

$pdo = (new SQLiteConnection())->connect();
if ($pdo != null)
    echo 'Connected to the SQLite database successfully!';
else
    exit("Could not connect to the SQLite database!");

(new SQLiteConnection())->initDB();
