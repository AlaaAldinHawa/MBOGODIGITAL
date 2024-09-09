<?php

// url: /admin/users/delete
// Dit is de controller-pagina voor het verwijderen van een gebruiker.

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
// Controleren of de pagina is aangeroepen met behulp van GET link.
// en of the variabelen wel bestaan.
// htmlspecialchars() wordt gebruikt om cross site scripting (xss) te voorkomen.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Verdnaam id opvangen en opslaan.
    if(isset($_GET["id"])) {
        $id = htmlspecialchars($_GET["id"]);
    }
    else {
        $errorMessage = "De id van de gebruiker is niet meegegeven.";
        callErrorPage($errorMessage);
    }
}
else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen GET gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren voordat een nieuwe pagina
// wordt getoond.
require_once __DOCUMENTROOT__ . '/models/Users.php';

$result = Users::delete($id);

// Controleren of het gelukt is om een gebruiker te verwijderen uit de database.
if ($result) {
    $message = "Gebruiker met de id $id is verwijderd.";
} else {
    $message = "Het is niet gelukt om deze gebruiker te verwijderen.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// Er wordt hier een redirect gedaan naar het overzicht van alle gebruikers.
// Het bericht de gebruiker is toegevoegd wordt meegestuurd als variabele.
$url = "/admin/users/overview/?message=$message";
header('Location: ' . $url, true);
exit();
