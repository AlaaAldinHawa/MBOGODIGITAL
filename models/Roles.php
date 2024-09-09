<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/docroot.php';
require_once __DOCUMENTROOT__ . '/config/globalvars.php';
require_once __DOCUMENTROOT__ . '/errors/default.php';
require_once __DOCUMENTROOT__ . '/database/dbconnection.php';
require_once __DOCUMENTROOT__ . '/vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class Role
{
    // insert voegt één nieuwe rol toe aan de tabel role.
    // Er wordt een UUIDv4 gegeneert als unieke ID.
    // Deze UUID wordt opgeslagen string (niet de snelste methode).
    public static function insert(
        $name,
        $level,
    ) {
        global $db;

        // Generate a version 4 (random) UUID
        $roleId = Uuid::uuid4();
        
        $sql_insert_into_roles = "INSERT INTO role (id, name, level)
        VALUES (?, ?, ?);";
        
        $stmt = $db->prepare($sql_insert_into_roles);
        
        if ($stmt->execute([
            $roleId, 
            $name,
            $level,
            ])) {
                return true;
        } else {
            return false;
        }
    }

    // select selecteert één rol op basis van een gegeven id.
    // Er wordt een associative array ($role["id"]) van de rol gereturneerd.
    public static function select($id) {
        global $db;

        $sql_select_role_by_id = "SELECT * FROM role WHERE id=?;";

        $stmt = $db->prepare($sql_select_role_by_id);

        if($stmt->execute([$id]) ){
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($roles as $role) {
                return $role;
            }
        }
    }

    // selectAll selecteert alle rollen. Geordend op level.
    // Er wordt een associative array met meerdere rijen gereturneerd.
    public static function selectAll() {
        global $db;

        $sql_selectAll_roles = "SELECT * FROM role ORDER by level;";
        
        $stmt = $db->prepare($sql_selectAll_roles);
        
        if($stmt->execute()){
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $roles;
        }
    }

    // update werkt de informatie van een record van een bepaalde id bij.
    // De functie returneerd true als dit gelukt is en false als het niet
    // gelukt is.
    public static function update(
        $id,
        $name,
        $level
    ){
        global $db;

        $sql_update_role_by_id = "UPDATE role
        SET name=?, level=?
        WHERE id=?";

        $stmt = $db->prepare($sql_update_role_by_id);

        if ( $stmt->execute([
            $name,
            $level,
            $id
        ]) ) {
            return true;
        } else {
            return false;
        }

    }

    // delete verwijdert een record uit de tabel role met een bepaald id.
    // De functie returneert true als dit gelukt is en false als dit niet gelukt is.
    public static function delete($id) {
        global $db;

        $sql_delete_rol_by_id = "DELETE FROM role WHERE id=?;";
        $stmt = $db->prepare($sql_delete_rol_by_id);
        if( $stmt->execute([$id]) ) {
            return true;

        } else {
            return false;
        }
    }
    
}