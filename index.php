<?php

/* 
 * Dit is de controller-pagina van de homepage.
 * deze bestaat uit drie gedeeltes.
 * 1. INLOGGEN CONTROLEREN
 * 2. INPUT CONTROLEREN
 * 3. CONTROLLER FUNCTIES
 * 4. VIEWS OPHALEN (REDIRECT
 */


require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Hier wordt gecontroleerd of de gebruiker is ingelogd en de juiste rechten
// heeft. De rollen "studenten" en "docenten" hebben toegang.
// n.v.t. 

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van form POST
// en of the variabelen wel bestaan.
// n.v.t.

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren voordat een nieuwe pagina
// wordt getoond.
require __DOCUMENTROOT__ . '/models/Educations.php';
$educations = Education::selectAll();

// 4. VIEWS OPHALEN (REDIRECT)
// De view voor de homepage wordt hier opgehaald.
// Dit wordt de titel van de homepagina.
$title = "Homepage MBOdigitaal";
require __DOCUMENTROOT__ . '/views/home.php';

/*
 * Als je autorisatie aan een pagina wilt toevoegen dan moet je de onderstaande regels
 * toevoegen boven aan de pagina.
 * 
 * // 1. INLOGGEN CONTROLEREN
 * // Hier wordt gecontroleerd of de gebruiker is ingelogd en de juiste rechten
 * // heeft. De rollen "studenten" en "docenten" hebben toegang. 
 * require __DOCUMENTROOT__ . '/models/Auth.php';
 * Auth::check(["studenten", "docenten"]);
 */ 