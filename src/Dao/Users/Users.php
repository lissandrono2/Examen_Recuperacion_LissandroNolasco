<?php

namespace Dao\Users;
use Dao\Table;

class Users extends Table
{
  public static function getUsers(
    string $partialName = "",
    string $status = "",
    string $orderBy = "",
    bool $orderDescending = false,
    int $page = 0,
    int $itemsPerPage = 10
  ) {
        $sqlstr = "SELECT p.usercod, p.useremail, p.username, p.userpswd, p.userest, p.usertipo, case when p.userest = 'ACT' then 'Activo' when p.userest = 'INA' then 'Inactivo' else 'Sin Asignar' end as userStatusDsc 
        FROM usuario p";
        $sqlstrCount = "SELECT COUNT(*) as count FROM usuario p";
        $conditions = [];
        $params = [];
        if ($partialName != "") {
        $conditions[] = "p.username LIKE :partialName";
        $params["partialName"] = "%" . $partialName . "%";
        }
        if (!in_array($status, ["ACT", "INA", ""])) {
        throw new \Exception("Error Processing Request Status has invalid value");
        }
        if ($status != "") {
        $conditions[] = "p.userest = :status";
        $params["status"] = $status;
        }
        if (count($conditions) > 0) {
        $sqlstr .= " WHERE " . implode(" AND ", $conditions);
        $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }
        if (!in_array($orderBy, ["usercode", "useremail", "username", ""])) {
        throw new \Exception("Error Processing Request OrderBy has invalid value");
        }
        if ($orderBy != "") {
        $sqlstr .= " ORDER BY " . $orderBy;
        if ($orderDescending) {
            $sqlstr .= " DESC";
        }
        }
        $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
        $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);
        if ($page > $pagesCount - 1) {
        $page = $pagesCount - 1;
        }
        $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;

        $registros = self::obtenerRegistros($sqlstr, $params);
        return ["usuario" => $registros, "total" => $numeroDeRegistros, "page" => $page, "itemsPerPage" => $itemsPerPage];
    }

    public static function getUserById(int $usercod)
    {
        $sqlstr = "SELECT p.usercod, p.useremail, p.username, p.userpswd, p.userest, p.usertipo FROM usuario p WHERE p.usercod = :usercod";
        $params = ["usercod" => $usercod];
        $userData = self::obtenerUnRegistro($sqlstr, $params);
        // Convert the user data to an associative array
        $userData = self::_getStructFrom($userData, array(
            "usercod" => $userData['usercod'],
            "useremail" => $userData['useremail'],
            "username" => $userData['username'],
            "userpswd" => $userData['userpswd'],
            "userest" => $userData['userest'],
            "usertipo" => $userData['usertipo'],
        ));
        return $userData;
    }

    public static function insertUser(
        string $usercod,
        string $useremail,
        string $username,
        string $userpswd,
        string $userest,
        string $usertipo
    ) {
        $sqlstr = "INSERT INTO usuario (usercod, useremail, username, userpswd, userest, usertipo) VALUES (:usercod, :useremail, :username, :userest, :usertipo)";
        $params = [
        "usercod" => $usercod,
        "useremail" => $useremail,
        "username" => $username,
        "userpswd" => $userpswd,
        "userest" => $userest,
        "usertipo" => $usertipo
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateUser(
        string $usercod,
        string $useremail,
        string $username,
        string $userpswd,
        string $userest,
        string $usertipo
    ) {
        $sqlstr = "UPDATE usuario SET useremail = :useremail, username = :username, userpswd = :userpswd, userest = :userest, usertipo = :usertipo WHERE usercod = :usercod";
        $params = [
        "usercod" => $usercod,
        "useremail" => $useremail,
        "username" => $username,
        "userpswd" => $userpswd,
        "userest" => $userest,
        "usertipo" => $usertipo
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteUser(int $usercod)
    {
        $sqlstr = "DELETE FROM usuario WHERE usercod = :usercod";
        $params = ["usercod" => $usercod];
        return self::executeNonQuery($sqlstr, $params);
    }

}
?>