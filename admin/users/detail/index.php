<?php

// url: /admin/educations/detail
// Dit is de controller-pagina voor het genereren van een detailpagina van
// één gebruiker.

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
// Controleren of de pagina is aangeroepen met behulp van een link (GET).
// Op dit moment hier niet van toepassing.
// De ID van de opleiding wordt hier opgevangen. 
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Veldnaam id opvangen en opslaan.
    if(isset($_GET["id"])) {
        $id = htmlspecialchars($_GET["id"]);
    }
    else {
        $errorMessage = "De id van de rol is niet meegegeven.";
        callErrorPage($errorMessage);
    }
}
else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen GET gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de juiste
// informatie te bewerken.
require_once __DOCUMENTROOT__ . '/models/Users.php';
require_once __DOCUMENTROOT__ . '/models/Educations.php';
require_once __DOCUMENTROOT__ . '/models/Roles.php';

$user = Users::select($id);
$education = Education::select($user["educationId"]);
$role = Role::select($user["roleId"]);

// 4. VIEWS OPHALEN
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$title = "Gebruiker detailoverzicht";
$editUrl = "/admin/users/edit/";
$overviewUrl = "/admin/users/overview/";
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
$educationNameValue = $education["name"];
$roleNameValue = $role["name"];
$cohortValue = $user["cohort"];
$creationDateValue = $user["creationDate"];
$modificationDateValue = $user["modificationDate"];
require __DOCUMENTROOT__ . '/views/admin/users/detailedview.php';