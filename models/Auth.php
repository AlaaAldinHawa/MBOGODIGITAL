<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/docroot.php';
require_once __DOCUMENTROOT__ . '/config/globalvars.php';
require_once __DOCUMENTROOT__ . '/errors/default.php';
require_once __DOCUMENTROOT__ . '/database/dbconnection.php';
require_once __DOCUMENTROOT__ . '/vendor/autoload.php';

require_once __DOCUMENTROOT__ . '/models/Users.php';
require_once __DOCUMENTROOT__ . '/models/Roles.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    // login controleert de gebruikersnaam (emailadres) en het wachtwoord (secret)
    // die de gebruiker heeft ingevuld in het formulier.
    // login maakt ook een cookie aan. Cookie is 1 uur geldig.
    // functie retureert true als het goed gaat.
    public static function login($email, $secret)
    {
        global $db;

        $sql_select_user_by_email = "SELECT * FROM user WHERE email=?";

        $stmt = $db->prepare($sql_select_user_by_email);

        // Gebruiker wordt opgezocht in de user tabel.
        // Als de gebruiker bestaat daarna wordt het wachtwoord gecontroleerd.
        if ($stmt->execute([$email])) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $user = $users[0];

            if (!$user) {
                callLoginPage("Er is geen gebruiker gevonden met dit emailadres.");
            }

            // Controleren of het gegeven wachtwoord overeen komt het het opgeslagen
            // wachtwoord.
            if (password_verify($secret, $user['secret'])) {

                global $jwtkey;
                // Aanmaken van de Jason Webtoken (JWT).
                // Geldigheid van het token is 8 uur.

                $role = Role::select($user["roleId"]);

                $token = JWT::encode(
                    array(
                        'iat' => time(),
                        'nbf' => time(),
                        'exp' => time() + 8 * 3600,
                        'data' => array(
                            'id' => $user['id'],
                            'roleName' => $role['name']
                        )
                    ),
                    $jwtkey,
                    'HS256'
                );

                // JWT wordt opgeslagen in de cookies van de gebruiker.
                setcookie(
                    "token",
                    $token,
                    time() + 8 * 3600,
                    "/",
                    "",
                    true,
                    true
                );
                return true;
            } else {
                callLoginPage("U inloggevens zijn niet juist.");
            }
        } else {
            callErrorPage("Het is niet gelukt om uw gegevens te controleren.");
        }
    }

    public static function check($rolesOrIds)
    {
        if (isset($_COOKIE['token'])) {

            $token = $_COOKIE['token'];
            global $jwtkey;
            $decoded = JWT::decode($token, new Key($jwtkey, 'HS256'));

            // Controleren of het account van de gebruiker wel actief is.
            $tokenId = $decoded->data->id;
            if (!Users::isEnabled($tokenId)) {
                callErrorPage("Uw account is niet actief.");
            }

            // Controleren of het token nog geldig is.
            $exp = (int) $decoded->exp;
            if ($exp < time()) {
                callLoginPage("U moet opnieuw inloggen. Uw sessie is verlopen.");
            }

            $tokenIsValid = false;
            // Controleren of de rol van de gebruiker is toegestaan.
            $tokenRole = $decoded->data->roleName;
            foreach ($rolesOrIds as $role) {
                if (strtolower($tokenRole) === strtolower($role)) {
                    $tokenIsValid = true;
                }
            }

            // Controleren of de ID van de gebruiker is toegestaan.
            foreach ($rolesOrIds as $id) {
                if ($tokenId === $id) {
                    $tokenIsValid = true;
                }
            }

            if ($tokenIsValid) {
                return true;
            }

            callLoginPage("U hebt niet de juiste rechten om deze pagina te bezoeken.");

        } else {
            callLoginPage("U bent niet ingelogd.");
        }
    }

    public static function checkResetPassword()
    {
        $id = Auth::getTokenId();

        if (Users::mustChangeSecretAtLogon($id)) {
            callResetPasswordPage($id);
        }
    }

    public static function logout()
    {
        setcookie("token", "", time() - 8 * 3600, "/", "", true, true);
    }

    private static function getTokenId()
    {
        if (isset($_COOKIE['token'])) {

            $token = $_COOKIE['token'];
            global $jwtkey;
            $decoded = JWT::decode($token, new Key($jwtkey, 'HS256'));

            return $decoded->data->id;
        }
    }
}

