<?php

// url: /admin/roles/add
// Dit is de controller-pagina voor het toevoegen van een nieuwe
// role afkomstig van het formulier /admin/roles/new.

// Globale variablen en functies die op bijna alle pagina's
// gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Hier wordt gecontroleerd of de gebruiker is ingelogd en de juiste rechten
// heeft. De rollen "applicatiebeheerder" en "administrator" hebben toegang. 
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check(["applicatiebeheerder", "administrator"]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van form POST
// en of the variabelen wel bestaan.
// htmlspecialchars() wordt gebruikt om cross site scripting (xss) te voorkomen.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verlnaam rolnaam opvangen en opslaan.
    if(isset($_POST["name"])) {
        $name = htmlspecialchars($_POST["name"]);
    }
    else {
        $errorMessage = "Rolnaam is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }
    
    // Veldnaam level opvangen en opslaan.
    if(isset($_POST["level"])) {
        $level = htmlspecialchars($_POST["level"]);
    }
    else {
        $errorMessage = "Level is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    } 
}
else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen POST gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren voordat een nieuwe pagina
// wordt getoond.
require_once __DOCUMENTROOT__ . '/models/Roles.php';

$result = Role::insert(
    $name,
    $level
);

// Controleren of het gelukt is om een rol toe te voegen aan de database.
if ($result) {
    $message = "Role met naam $name met level $level is toegevoegd.";
} else {
    $message = "Het is niet gelukt om een nieuwe rol toe te voegen.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// Er wordt hier een redirect gedaan naar het overzicht van alle rollen.
// Het bericht de gebruiker is toegevoegd wordt meegestuurd als variabele.
$url = "/admin/roles/overview/?message=$message";
header('Location: ' . $url, true);
exit();