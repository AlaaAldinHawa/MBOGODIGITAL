<?php

// url: /errorpage
// Dit is de controller-pagina voor de webpagina met de foutmelding.

// Globale variablen en functies die op bijna alle pagina's
// gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require_once __DOCUMENTROOT__ . '/config/globalvars.php';
require_once __DOCUMENTROOT__ . '/errors/default.php';


// 1. INLOGGEN CONTROLEREN
// Hier wordt gecontroleerd of de gebruiker is ingelogd en de juiste rechten
// heeft. De rollen "applicatiebeheerder" en "administrator" hebben toegang.
// n.v.t.

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van een link (GET).
// Op dit moment hier niet van toepassing.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Verlnaam rolnaam opvangen en opslaan.
    if(isset($_GET["message"])) {
        $errorMessage = $_GET["message"];
    }
    else {
        $errorMessage = "Geen bericht over de foutmelding.";
    } 
}
else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen POST gebruikt.";
} 

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de juiste
// informatie te bewerken.
// n.v.t.

// 4. VIEWS OPHALEN
// De HTML-pagina (view) wordt hier opgehaald.
// $title is de titel van de html pagina.
$title = "Pagina foutmelding";
require __DOCUMENTROOT__ . '/views/errors/default.php';