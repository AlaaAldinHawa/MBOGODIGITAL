<?php

// url: /admin/roles/detail
// Dit is de controller-pagina voor het genereren van een detailpagina van
// één opleiding.

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
require_once __DOCUMENTROOT__ . '/models/Educations.php';

$education = Education::select($id);


// 4. VIEWS OPHALEN
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$title = "Opleiding detailoverzicht";
$id = $education["id"];
$creboNumber = $education["creboNumber"];
$name = $education["name"];
$level = $education["level"];
$description = $education["description"];
$registerUntil = $education["registerUntil"];
$graduateUntil = $education["graduateUntil"];
$editUrl = "/admin/educations/edit/";
$overviewUrl = "/admin/educations/overview/";
require __DOCUMENTROOT__ . '/views/admin/educations/detailedview.php';