<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/docroot.php';
require_once __DOCUMENTROOT__ . '/config/globalvars.php';
require_once __DOCUMENTROOT__ . '/errors/default.php';
require_once __DOCUMENTROOT__ . '/database/dbconnection.php';
require_once __DOCUMENTROOT__ . '/vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class Users
{
    // insert voegt één nieuwe gebruiker toe aan de tabel user.
    // Er wordt een UUIDv4 gegeneert als unieke ID.
    // Deze UUID wordt opgeslagen string (niet de snelste methode).
    public static function insert(
        $duoNumber,
        $firstName,
        $prefix,
        $lastName,
        $secret,
        $email,
        $phone,
        $changeSecretAtLogon,
        $enabled,
        $roleId,
        $educationId,
        $cohort,
    ) {
        global $db;

        if (Users::checkEmailIsUnique($email) === false) {
            return "Emailadres bestaat al is en is dus niet uniek.";
        }

        $creationDate = date('Y-m-d H:i:s');
        $modificationDate = date('Y-m-d H:i:s');

        // Generate a version 4 (random) UUID
        $id = Uuid::uuid4();

        $sql_insert_into_users = "INSERT INTO user (id, duoNumber, firstName, prefix, lastName, secret, email, phone, changeSecretAtLogon, enabled, roleId, educationId, cohort, creationDate, modificationDate)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $encryptedSecret = password_hash($secret, PASSWORD_DEFAULT);

        $stmt = $db->prepare($sql_insert_into_users);

        if (
            $stmt->execute([
                $id,
                $duoNumber == "" ? 0 : (int) $duoNumber,
                $firstName,
                $prefix,
                $lastName,
                $encryptedSecret,
                $email,
                $phone,
                $changeSecretAtLogon,
                $enabled,
                $roleId,
                $educationId,
                $cohort = "" ? null : $cohort,
                $creationDate,
                $modificationDate
            ])
        ) {
            return true;
        } else {
            return false;
        }
    }

    // select selecteert één gebruiker op basis van een gegeven id.
    // Er wordt een associative array ($user["id"]) van de gebruiker gereturneerd.
    public static function select($id)
    {
        global $db;

        $sql_select_users_by_id = "SELECT * FROM user WHERE id=?;";

        $stmt = $db->prepare($sql_select_users_by_id);

        if ($stmt->execute([$id])) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {
                return $user;
            }
        }
    }

    // selectAll selecteert alle gebruikers geordend op een zelf aangegeven waarde $orderBy.
    // Er wordt een associative array met meerdere rijen gereturneerd.
    // Deze functies returneert een x aantal records ($numberOfRecords). Default 100 records.
    // $offset zijn het aantal records dat hij overslaat. Default 0 records overslaan.
    public static function selectAll($orderBy, $numberOfRecords = 200, $offset = 0)
    {
        global $db;

        $sql_selectAll_users = "SELECT * FROM user ORDER by $orderBy LIMIT $numberOfRecords OFFSET $offset;";

        $stmt = $db->prepare($sql_selectAll_users);

        if ($stmt->execute()) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }
    }

    // update werkt de informatie van een record van een bepaalde id bij.
    // De functie returneerd true als dit gelukt is en false als het niet
    // gelukt is.
    public static function update(
        $id,
        $duoNumber,
        $firstName,
        $prefix,
        $lastName,
        $email,
        $phone,
        $changeSecretAtLogon,
        $enabled,
        $roleId,
        $educationId,
        $cohort
    ) {
        global $db;

        $modificationDate = date('Y-m-d H:i:s');

        $sql_update_user_by_id = "UPDATE user
        SET duoNumber=?, firstName=?, prefix=?, lastName=?, email=?, phone=?, changeSecretAtLogon=?, enabled=?, roleId=?, educationId=?, cohort=?, modificationDate=?
        WHERE id=?";

        $stmt = $db->prepare($sql_update_user_by_id);

        if (
            $stmt->execute([
                $duoNumber,
                $firstName,
                $prefix,
                $lastName,
                $email,
                $phone,
                $changeSecretAtLogon,
                $enabled,
                $roleId,
                $educationId,
                $cohort,
                $modificationDate,
                $id
            ])
        ) {
            return true;
        } else {
            return false;
        }

    }

    // delete verwijdert een record uit de tabel user met een bepaald id.
    // De functie returneert true als dit gelukt is en false als dit niet gelukt is.
    public static function delete($id)
    {
        global $db;

        $sql_delete_user_by_id = "DELETE FROM user WHERE id=?;";
        $stmt = $db->prepare($sql_delete_user_by_id);
        if ($stmt->execute([$id])) {
            return true;

        } else {
            return false;
        }
    }

    public static function changeSecret($id, $newSecret)
    {
        global $db;

        $modificationDate = date('Y-m-d H:i:s');
        $encryptedSecret = password_hash($newSecret, PASSWORD_DEFAULT);

        $sql_update_user_secret_by_id = "UPDATE user
        SET secret=?, modificationDate=?
        WHERE id=?";

        $stmt = $db->prepare($sql_update_user_secret_by_id);

        if (
            $stmt->execute([
                $encryptedSecret,
                $modificationDate,
                $id
            ])
        ) {
            return true;
        } else {
            return false;
        }

    }

    public static function resetSecret($id, $oldSecret, $newSecret)
    {

        if (Users::checkSecret($id, $oldSecret)) {
            Users::changeSecret($id, $newSecret);
            Users::resetChangeSecretAtLogon($id, false);
            return true;
        } else {
            return false;
        }

    }

    public static function eduarteUpload(
        $dest_path,
        $secret,
        $changeSecretAtLogon,
        $enabled,
        $roleId,
        $educationId,
        $cohort
    ) {
        if (($handle = fopen($dest_path, "r")) !== FALSE) {
            while (($studentRow = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $studentRowArray = explode(";", $studentRow[0]);

                $duoNumber = $studentRowArray[0];
                $firstName = $studentRowArray[1];
                $prefix = $studentRowArray[2];
                $lastName = $studentRowArray[3];
                $email = $studentRowArray[9];
                $phone = "";

                if (Users::checkEmailIsUnique($email)) {
                    if (strtolower($firstName) != strtolower("roepnaam")) {
                        $result = Users::insert(
                            $duoNumber,
                            $firstName,
                            $prefix,
                            $lastName,
                            $secret,
                            $email,
                            $phone,
                            $changeSecretAtLogon,
                            $enabled,
                            $roleId,
                            $educationId,
                            $cohort
                        );

                        // // Controleren of het gelukt is om een gebruiker toe te voegen aan de database.
                        if ($result !== true) {
                            return false;
                        }
                    }
                }
            }
            fclose($handle);
            unlink($dest_path);
            return true;
        } else {
            return false;
        }

    }

    // isEnabled controleert of het account van de gebruiker is
    // geactiveerd. Returneert true als dit zo is anders false.
    public static function isEnabled($id)
    {
        global $db;

        $sql_select_users_by_id = "SELECT enabled FROM user WHERE id=?;";

        $stmt = $db->prepare($sql_select_users_by_id);

        if ($stmt->execute([$id])) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {

                if ($user["enabled"]) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    // mustChangeSecreteAtLogon controleert of de gebruiker zijn
    // wachtwoord moet wijzigen. Returneert true als dit zo is anders false.
    public static function mustChangeSecretAtLogon($id)
    {
        global $db;

        $sql_select_users_by_id = "SELECT changeSecretAtLogon FROM user WHERE id=?;";

        $stmt = $db->prepare($sql_select_users_by_id);

        if ($stmt->execute([$id])) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {

                if ($user["changeSecretAtLogon"] === 0) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    public static function resetChangeSecretAtLogon($id, $mustReset)
    {
        global $db;

        $sql_update_user_by_id = "UPDATE user SET changeSecretAtLogon=? WHERE id=?";

        $stmt = $db->prepare($sql_update_user_by_id);

        if ($stmt->execute([
            $mustReset === true ? 1 : 0,
            $id
        ])){
            return true;
        } else {
            return false;
        }
    }

    private static function checkSecret($id, $secret)
    {
        global $db;

        $sql_select_users_by_id = "SELECT id, secret FROM user WHERE id=?;";

        $stmt = $db->prepare($sql_select_users_by_id);

        if ($stmt->execute([$id])) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {

                if (password_verify($secret, $user['secret'])) {
                    return true;
                } else {
                    return true;
                }
            }
        }
    }

    private static function checkEmailIsUnique($email)
    {
        global $db;

        $sql_select_users_by_email = "SELECT * FROM user WHERE email=?;";

        $stmt = $db->prepare($sql_select_users_by_email);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            return false;           // Email is niet uniek.
        } else {
            return true;            // Email is wel uniek.
        }
    }
}