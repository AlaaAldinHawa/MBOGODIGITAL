<?php

// url: /admin/users/edit
// Dit is de controller-pagina voor het bewerkingsformulier van een bestaande opleiding.

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
// Informatie van bestaande gebruiker wordt opgehaald uit de database.
require_once __DOCUMENTROOT__ . '/models/Users.php';
require_once __DOCUMENTROOT__ . '/models/Educations.php';
require_once __DOCUMENTROOT__ . '/models/Roles.php';

$user = Users::select($id);
$educations = Education::selectAll();
$roles = Role::selectAll();

// Controleren of het gelukt is om een gebruiker toe te voegen aan de database.
if (!$user) {
    $message = "Het is niet gelukt om de gebruiker met de id $id op te halen.";
    callErrorPage($message);
}

// 4. VIEWS OPHALEN (REDIRECT)
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$title = "Formulier gebruiker bewerken";
$editmode = true;
$actionUrl = "/admin/users/update/";
$editUrl = "/admin/users/edit/";
$idValue = $user["id"];
$duoNumberValue = $user["duoNumber"];
$firstNameValue = $user["firstName"];
$prefixValue = $user["prefix"];
$lastNameValue = $user["lastName"];
$emailValue = $user["email"];
$phoneValue = $user["phone"];
$changeSecretAtLogonValue = $user["changeSecretAtLogon"];
$enabledValue = $user["enabled"];
$roleIdValue = $user["roleId"];
$educationIdValue = $user["educationId"];
$cohortValue = $user["cohort"];
$creationDateValue = $user["creationDate"];
$modificationDateValue = $user["modificationDate"];
require __DOCUMENTROOT__ . '/views/admin/users/form.php';
