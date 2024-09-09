<?php

// url: /auth/changePassword
// Dit is de controller-pagina voor het veranderen van het wachtwoord 
// van een gebruiker. 
// Afkomstig van het formulier /auth/changePasswordForm

// Globale variablen en functies die op bijna alle pagina's
// gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Hier wordt gecontroleerd of de gebruiker is ingelogd.
// Alleen de gebruiker zelf mag zijn eigen wachtwoord wijzigen. 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veldnaam id opvangen en opslaan.
    if (isset($_POST["id"])) {
        $id = htmlspecialchars($_POST["id"]);
    } else {
        $errorMessage = "id is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }
}
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check([$id]);


// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van form POST
// en of the variabelen wel bestaan.
// htmlspecialchars() wordt gebruikt om cross site scripting (xss) te voorkomen.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veldnaam oldPassword opvangen en opslaan.
    if (isset($_POST["oldPassword"])) {
        $oldPassword = htmlspecialchars($_POST["oldPassword"]);
    } else {
        $errorMessage = "Oud wachtwoord is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam newPassword1 opvangen en opslaan.
    if (isset($_POST["newPassword1"])) {
        $newPassword1 = htmlspecialchars($_POST["newPassword1"]);
    } else {
        $errorMessage = "Eerste wachtwoord is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam newPassword2 opvangen en opslaan.
    if (isset($_POST["newPassword2"])) {
        $newPassword2 = htmlspecialchars($_POST["newPassword2"]);
    } else {
        $errorMessage = "Tweede wachtwoord is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }
} else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen POST gebruikt.";
    callErrorPage($errorMessage);
}


// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de gebruiker te laten inloggen.

require __DOCUMENTROOT__ . '/models/Users.php';

if ($newPassword1 === $newPassword2) {
    $result = Users::resetSecret(
        $id,
        $oldPassword,
        $newPassword1
    );

    if ($result) {
        $message = "Uw wachtwoord is gewijzigd.";
    } else {
        $message = "Het is niet gelukt uw wachtwoord te wijzigen.";
        callErrorPage($errorMessage);
    }
}

// 4. VIEWS OPHALEN (REDIRECT)
// Er wordt hier een redirect gedaan naar het overzicht van alle gebruikers.
// Het bericht de gebruiker is toegevoegd wordt meegestuurd als variabele.
$url = "/admin/users/overview?message=$message";
header('Location: ' . $url, true);
exit();

