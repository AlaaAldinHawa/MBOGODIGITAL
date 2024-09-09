<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require_once __DOCUMENTROOT__ . '/config/db.php';
require_once __DOCUMENTROOT__ . '/errors/default.php';

$dsn = "mysql:host=$host;dbname=$dbName;charset=UTF8";

try {
    $db = new PDO($dsn, $user, $password);
    // if ($pdo) {
    //     echo "Connected to the $db database successfully!";
    // }
} catch (PDOException $e) {
    // echo $e;
    callErrorPage("Er kan geen verbinding worden gemaakt met de databaseserver");
}
