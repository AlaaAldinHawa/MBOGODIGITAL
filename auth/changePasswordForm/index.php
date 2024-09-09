<?php

// url: /auth/changePassword
// Dit is de controller-pagina inloggen van een gebruiker
// gebruiker afkomstig van het formulier /auth/loginform

// Globale variablen en functies die op bijna alle pagina's
// gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 1. INLOGGEN CONTROLEREN
// Hier wordt gecontroleerd of de gebruiker is ingelogd.
// Alleen de gebruiker zelf mag zijn eigen wachtwoord wijzigen. 
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Veldnaam id opvangen en opslaan.
    if (isset($_GET["id"])) {
        $id = htmlspecialchars($_GET["id"]);
    } else {
        $errorMessage = "id is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }
}
require __DOCUMENTROOT__ . '/models/Auth.php';
Auth::check([$id]);

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van form POST
// en of the variabelen wel bestaan.
// htmlspecialchars() wordt gebruikt om cross site scripting (xss) te voorkomen.


// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de gebruiker het formulier te laten zien.


// 4. VIEWS OPHALEN (REDIRECT)
// 
$title = "Wachtwoord resetten";
$actionUrl = "/auth/changePassword";
require __DOCUMENTROOT__ . '/views/admin/auth/changePasswordForm.php';

