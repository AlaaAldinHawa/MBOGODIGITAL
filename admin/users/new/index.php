<?php

// url: /admin/educations/new
// Dit is de controller-pagina voor het formulier toevoegen van 
// een nieuwe opleiding.

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

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de juiste
// informatie te bewerken.
require_once __DOCUMENTROOT__ . '/models/Educations.php';
require_once __DOCUMENTROOT__ . '/models/Roles.php';

$roles = Role::selectAll();
$educations = Education::selectAll();


// 4. VIEWS OPHALEN
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$title = "Gebruiker toevoegen";
$editmode = false;
$actionUrl = "/admin/users/add/";
$overviewUrl = "/admin/users/overview/";
$changeSecretAtLogonValue = 1;
$enabledValue = 1;
require __DOCUMENTROOT__ . '/views/admin/users/form.php';