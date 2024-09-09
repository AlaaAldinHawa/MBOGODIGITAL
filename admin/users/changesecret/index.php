<?php

// url: /admin/users/changesecret
// Dit is de controller-pagina voor het veranderen van een gebruikersnaam.
// Vanuit het overzicht van alle gebruikers kan het wachtwoord gewijzigd worden.

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
    // Veldnaam id opvangen en opslaan.
    if (isset($_POST["id"])) {
        $id = htmlspecialchars($_POST["id"]);
    } else {
        $errorMessage = "id is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam id opvangen en opslaan.
    if (isset($_POST["password"])) {
        $newSecret = htmlspecialchars($_POST["password"]);
    } else {
        $errorMessage = "secret is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

} else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen POST gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren voordat een nieuwe pagina
// wordt getoond.
require_once __DOCUMENTROOT__ . '/models/Users.php';

$result = Users::changeSecret($id, $newSecret);

// // Controleren of het gelukt is om een gebruiker toe te voegen aan de database.
if ($result) {
    $message = "Het wachtwoord van de gebruiker is veranderd.";
} else {
    $message = "Het is niet gelukt om het wachtwoord te wijzigen van de gebruiker.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// Er wordt hier een redirect gedaan naar het overzicht van alle gebruikers.
// Het bericht de gebruiker is toegevoegd wordt meegestuurd als variabele.
$url = "/admin/users/overview/?message=$message";
header('Location: ' . $url, true);
exit();
