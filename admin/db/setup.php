<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/dbconnection.php';

// Pad waar de database setup in staat.
$sqlFile = 'setup.sql';

try {
    // Zorg dat alle foutmeldigen worden weergegeven.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lees het hele bestand setup.sql in één variable als string.
    $sql = file_get_contents($sqlFile);

    // Geef een foutmelding als het niet gelukt is om het bestand te lezen.
    // Of het bestand niet bestaat.
    if ($sql === false) {
        throw new Exception('Error reading SQL file');
    }

    // Execute alle sql commando's.
    // Geef een melding dat het gelukt is.
    $db->exec($sql);
    echo 'SQL file succesvol geïmporteerd.';
    
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'General error: ' . $e->getMessage();
}
