<?php

// url: /admin/educations/edit
// Dit is de controller-pagina voor het bewerkingsformulier van een bestaande opleiding.

// Globale variablen en functies die op bijna alle pagina's
// gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';;

// 1. INLOGGEN CONTROLEREN
// Hier wordt gecontroleerd of de gebruiker is ingelogd en de juiste rechten
// heeft. De rollen "applicatiebeheerder" en "administrator" hebben toegang. 
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check(["applicatiebeheerder", "administrator"]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van form GET
// en of the variabelen wel bestaan.
// htmlspecialchars() wordt gebruikt om cross site scripting (xss) te voorkomen.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Veldnaam id opvangen en opslaan.
    if(isset($_GET["id"])) {
        $id = htmlspecialchars($_GET["id"]);
    }
    else {
        $errorMessage = "De id van de opleiding is niet meegegeven.";
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
// Informatie van bestaande opleiding wordt opgehaald uit de database.
require_once __DOCUMENTROOT__ . '/models/Educations.php';

$education = Education::select($id);

// Controleren of het gelukt is om een opleiding toe te voegen aan de database.
if (!$education) {
    $message = "Het is niet gelukt om een opleiding met de id $id op te halen.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$title = "Formulier opleiding bewerken";
$editmode = true;
$actionUrl = "/admin/educations/update/";
$idValue = $education["id"];
$creboNumberValue = $education["creboNumber"];
$nameValue = $education["name"];
$levelValue = $education["level"];
$descriptionValue = $education["description"];
$registerUntilValue = $education["registerUntil"];
$graduateUntilValue = $education["graduateUntil"];
$editUrl = "/admin/educations/edit/";
require __DOCUMENTROOT__ . '/views/admin/educations/form.php';
