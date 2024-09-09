<?php

// url: /auth/login
// Dit is de controller-pagina inloggen van een gebruiker
// gebruiker afkomstig van het formulier /auth/loginform

// Globale variablen en functies die op bijna alle pagina's
// gebruikt worden.
require $_SERVER["DOCUMENT_ROOT"] . '/docroot.php';
require __DOCUMENTROOT__ . '/config/globalvars.php';
require __DOCUMENTROOT__ . '/errors/default.php';

// 2. INPUT CONTROLEREN
// Controleren of de pagina is aangeroepen met behulp van form POST
// en of the variabelen wel bestaan.
// htmlspecialchars() wordt gebruikt om cross site scripting (xss) te voorkomen.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veldnaam email opvangen en opslaan.
    if (isset($_POST["email"])) {
        $email = htmlspecialchars($_POST["email"]);
    } else {
        $errorMessage = "Emailadres is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }

    // Veldnaam secret opvangen en opslaan.
    if (isset($_POST["password"])) {
        $secret = htmlspecialchars($_POST["password"]);
    } else {
        $errorMessage = "Wachtwoord is niet ingevuld of ontbreekt.";
        callErrorPage($errorMessage);
    }
} else {
    $errorMessage = "De pagina is op onjuiste manier aangeroepen. Geen POST gebruikt.";
    callErrorPage($errorMessage);
}

// 3. CONTROLLER FUNCTIES
// Hier vinden alle acties plaats die moeten gebeuren om de gebruiker te laten inloggen.
require __DOCUMENTROOT__ . '/models/Auth.php';

$result = Auth::login(
    $email,
    $secret
);

if ($result) {
    $message = "U bent nu ingelogd met het emailadres $email.";
} else {
    $message = "U bent niet ingelogd op het systeem. Probeer het nog eens.";
    callErrorPage($errorMessage);
}

// 4. VIEWS OPHALEN (REDIRECT)
// Er wordt hier een redirect gedaan naar het overzicht van alle gebruikers.
// Het bericht de gebruiker is toegevoegd wordt meegestuurd als variabele.
$url = "/admin/users/overview/?message=$message";
header('Location: ' . $url, true);
exit();

