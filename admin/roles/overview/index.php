<?php

// url: /admin/roles/overview
// Dit is de controller-pagina voor het genereren van een overzicht
// van alle rollen.

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
// Na het toevoegen, bewerken of verwijderen wordt deze pagina aangeroepen. 
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Message afkomst van andere pagina.
    if(isset($_GET["message"])) {
        $message = htmlspecialchars($_GET["message"]);
    }
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de juiste
// informatie te bewerken.
require_once __DOCUMENTROOT__ . '/models/Roles.php';

$roles = Role::selectAll();

// Controleren of het gelukt is om een rol toe te voegen aan de database.
if (!$roles) {
    $message = "Het is niet gelukt om alle rollen op te halen uit de database.";
    callErrorPage($message);
}

// echo "<pre>";
// print_r($roles);
// echo "</pre>";

// 4. VIEWS OPHALEN
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$newUrl = "/admin/roles/new/";
$title = "Overzicht rollen";
require __DOCUMENTROOT__ . '/views/admin/roles/overview.php';