<?php

// Met deze gebruiker krijg je altijd toegang tot het adminpanel.
// Ook als deze niet in de database staat.
// Wachtwoord is NIET gehashed.
// Deze gebruiker moet alleen gebruikt worden in noodgevallen.
return $buildInAdminUser= [
    "uuid" => "f47ac10b-58cc-4372-a567-0e02b2c3d479",
    "username" => "administrator",
    "secret" => "EFO5lsHpC5h80pI9giNnJz0GlN3ZWbIhQSASgRCJILo0m7WT",
];

/*
 * Handleiding
 * 
 * In andere files kan deze gebruikersinformatie als volgt worden opgehaald.
 * In de globalvars.php file staat de constante __DOCUMENTROOT__. Vandaar
 * dat deze nodig is.
 * 
 * require $_SERVER['DOCUMENT_ROOT'] . '/config/globalvars.php';
 * $buildInAdminUser = require __DOCUMENTROOT__ . '/config/buildinadminuser.php';
 * 
 * Gebruik deze variabele als volgt.
 * echo $buildInAdminUser["username"];
 * 
 */

