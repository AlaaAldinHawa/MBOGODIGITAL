<?php

// url: /admin/users/add
// Dit is de controller-pagina voor het toevoegen van een nieuwe
// gebruiker afkomstig van het formulier /admin/users/new.

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
    // Veldnaam duoNumber opvangen en opslaan.
    if (isset($_POST["duoNumber"])) {
        $duoNumber = htmlspecialchars($_POST["duoNumber"]);
    } else {
        $errorMessage = "DUO nummber is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam firstName opvangen en opslaan.
    if (isset($_POST["firstName"])) {
        $firstName = htmlspecialchars($_POST["firstName"]);
    } else {
        $errorMessage = "Voornaam is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam prefix opvangen en opslaan.
    if (isset($_POST["prefix"])) {
        $prefix = htmlspecialchars($_POST["prefix"]);
    } else {
        $errorMessage = "Tussenvoegsels is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam lastName opvangen en opslaan.
    if (isset($_POST["lastName"])) {
        $lastName = htmlspecialchars($_POST["lastName"]);
    } else {
        $errorMessage = "Achternaam is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam secret opvangen en opslaan.
    if (isset($_POST["secret"])) {
        $secret = htmlspecialchars($_POST["secret"]);
    } else {
        $errorMessage = "Wachtwoord is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam email opvangen en opslaan.
    if (isset($_POST["email"])) {
        $email = htmlspecialchars($_POST["email"]);
    } else {
        $errorMessage = "Email is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam phone opvangen en opslaan.
    if (isset($_POST["phone"])) {
        $phone = htmlspecialchars($_POST["phone"]);
    } else {
        $errorMessage = "Telefoonnummer is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam changeSecretAtLogon opvangen en opslaan.
    if (isset($_POST["changeSecretAtLogon"])) {
        $changeSecretAtLogon = 1;
    } else {
        $changeSecretAtLogon = 0;
    }

    // Veldnaam enabled opvangen en opslaan.
    if (isset($_POST["enabled"])) {
        $enabled = 1;
    } else {
        $enabled = 0;
    }

    // Veldnaam roleId opvangen en opslaan.
    if (isset($_POST["roleId"])) {
        $roleId = htmlspecialchars($_POST["roleId"]);
    } else {
        $errorMessage = "Id van de rol is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam educationId opvangen en opslaan.
    if (isset($_POST["educationId"])) {
        $educationId = htmlspecialchars($_POST["educationId"]);
    } else {
        $errorMessage = "Id van de opleiding is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam cohort opvangen en opslaan.
    if (isset($_POST["cohort"])) {
        $cohort = (int)htmlspecialchars($_POST["cohort"]);
    } else {
        $errorMessage = "Cohort is niet ingevuld of ontbreekt.";
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

$result = Users::insert(
    $duoNumber,
    $firstName,
    $prefix,
    $lastName,
    $secret,
    $email,
    $phone,
    $changeSecretAtLogon,
    $enabled,
    $roleId,
    $educationId,
    $cohort
);

// // Controleren of het gelukt is om een gebruiker toe te voegen aan de database.
if ($result === true) {
    $message = "Gebruiker met DUO nummer $duoNumber en achternaam $lastName is toegevoegd.";
} else {
    $message = $result;
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// Er wordt hier een redirect gedaan naar het overzicht van alle gebruikers.
// Het bericht de gebruiker is toegevoegd wordt meegestuurd als variabele.
$url = "/admin/users/overview/?message=$message";
header('Location: ' . $url, true);
exit();
