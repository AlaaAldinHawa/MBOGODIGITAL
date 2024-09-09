<?php

// url: /admin/educations/add
// Dit is de controller-pagina voor het toevoegen van een nieuwe
// opleiding afkomstig van het formulier /admin/educations/new.

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
    // Veldnaam creboNumber opvangen en opslaan.
    if (isset($_POST["creboNumber"])) {
        $creboNumber = htmlspecialchars($_POST["creboNumber"]);
    } else {
        $errorMessage = "Crebo Nummer is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam name opvangen en opslaan.
    if (isset($_POST["name"])) {
        $name = htmlspecialchars($_POST["name"]);
    } else {
        $errorMessage = "Naam van de opleiding is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam level opvangen en opslaan.
    if (isset($_POST["level"])) {
        $level = htmlspecialchars($_POST["level"]);
    } else {
        $errorMessage = "Niveau van de opleiding is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam description opvangen en opslaan.
    if (isset($_POST["description"])) {
        $description = htmlspecialchars($_POST["description"]);
    } else {
        $errorMessage = "Omschrijving van de opleiding is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam registerUntil opvangen en opslaan.
    if (isset($_POST["registerUntil"])) {
        $registerUntil = htmlspecialchars($_POST["registerUntil"]);
    } else {
        $errorMessage = "Inschrijving tot datum van de opleiding is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam graduateUntil opvangen en opslaan.
    if (isset($_POST["graduateUntil"])) {
        $graduateUntil = htmlspecialchars($_POST["graduateUntil"]);
    } else {
        $errorMessage = "Diplomeren tot datum van de opleiding is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }
} else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen POST gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren voordat een nieuwe pagina
// wordt getoond.
require_once __DOCUMENTROOT__ . '/models/Educations.php';

$result = Education::insert(
    $creboNumber,
    $name,
    $level,
    $description,
    $registerUntil,
    $graduateUntil
);

// // Controleren of het gelukt is om een opleiding toe te voegen aan de database.
if ($result) {
    $message = "Opleiding met naam $name met het niveau $level is toegevoegd.";
} else {
    $message = "Het is niet gelukt om een nieuwe opleiding toe te voegen.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// Er wordt hier een redirect gedaan naar het overzicht van alle opleidingen.
// Het bericht de gebruiker is toegevoegd wordt meegestuurd als variabele.
$url = "/admin/educations/overview/?message=$message";
header('Location: ' . $url, true);
exit();
