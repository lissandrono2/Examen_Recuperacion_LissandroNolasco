<?php

namespace Dao\Security;

use Dao\Table;

class Usuario extends Table
{
    public static function getAll()
    {
        return self::obtenerRegistros("SELECT * FROM usuario", []);
    }

    public static function getByPrimaryKey($usercod)
    {
        return self::obtenerUnRegistro(
            "SELECT * FROM usuario WHERE usercod = :usercod;",
            ["usercod" => $usercod]
        );
    }

    public static function add($usercod = null, $useremail = null, $username = null, $userpswd = null, $userfching = null, $userpswdest = null, $userpswdexp = null, $userest = null, $useractcod = null, $userpswdchg = null, $usertipo = null)
    {
        return self::executeNonQuery(
            "INSERT INTO usuario (usercod, useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, useractcod, userpswdchg, usertipo) VALUES (:usercod, :useremail, :username, :userpswd, :userfching, :userpswdest, :userpswdexp, :userest, :useractcod, :userpswdchg, :usertipo);",
            ["usercod" => $usercod, "useremail" => $useremail, "username" => $username, "userpswd" => $userpswd, "userfching" => $userfching, "userpswdest" => $userpswdest, "userpswdexp" => $userpswdexp, "userest" => $userest, "useractcod" => $useractcod, "userpswdchg" => $userpswdchg, "usertipo" => $usertipo]
        );
    }

    public static function update($usercod = null, $useremail = null, $username = null, $userpswd = null, $userfching = null, $userpswdest = null, $userpswdexp = null, $userest = null, $useractcod = null, $userpswdchg = null, $usertipo = null)
    {
        return self::executeNonQuery(
            "UPDATE usuario SET useremail = :useremail, username = :username, userpswd = :userpswd, userfching = :userfching, userpswdest = :userpswdest, userpswdexp = :userpswdexp, userest = :userest, useractcod = :useractcod, userpswdchg = :userpswdchg, usertipo = :usertipo WHERE usercod = :usercod;",
            ["usercod" => $usercod, "useremail" => $useremail, "username" => $username, "userpswd" => $userpswd, "userfching" => $userfching, "userpswdest" => $userpswdest, "userpswdexp" => $userpswdexp, "userest" => $userest, "useractcod" => $useractcod, "userpswdchg" => $userpswdchg, "usertipo" => $usertipo]
        );
    }

    public static function delete($usercod = null)
    {
        return self::executeNonQuery(
            "DELETE FROM usuario WHERE usercod = :usercod;",
            ["usercod" => $usercod]
        );
    }
}
