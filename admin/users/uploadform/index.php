<?php

// url: /admin/users/uploadform
// Dit is de controller-pagina voor het genereren van het upload formulier.

// Globale variabelen en functies die op bijna alle pagina's
// gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require_once __DOCUMENTROOT__ . '/config/globalvars.php';
require_once __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Hier wordt gecontroleerd of de gebruiker is ingelogd en de juiste rechten
// heeft. De rollen "applicatiebeheerder" en "administrator" hebben toegang.
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check(["applicatiebeheerder", "administrator"]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van een link (GET).
// Op dit moment hier niet van toepassing.
// Na het bewerken van 
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Message afkomst van andere pagina.
    if(isset($_GET["message"])) {
        $message = htmlspecialchars($_GET["message"]);
    }
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de juiste
// informatie te bewerken.
require_once __DOCUMENTROOT__ . '/models/Users.php';
require_once __DOCUMENTROOT__ . '/models/Educations.php';
require_once __DOCUMENTROOT__ . '/models/Roles.php';

$roles = Role::selectAll();
$educations = Education::selectAll();

// 4. VIEWS OPHALEN
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$changeSecretAtLogonValue = 1;
$enabledValue = 1;
$secretValue = "Welkom01!";
$cohortValue = "2024";
$uploadUrl = "/admin/users/upload/";
$title = "Gebruikers uploaden";
require __DOCUMENTROOT__ . '/views/admin/users/uploadform.php';