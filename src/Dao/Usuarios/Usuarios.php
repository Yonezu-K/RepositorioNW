<?php

namespace Dao\Usuarios;

use Dao\Table;

class Usuarios extends Table
{
    public static function obtenerUsuario(): array
    {
        $sqlstr = "SELECT * from usuario";
        return self::obtenerRegistros($sqlstr, []);
    }
    public static function obtenerUsuarioPorCodigo(string $usercod): array
    {
        $sqlstr = "SELECT * from usuario where usercod=:usercod;";
        return self::obtenerUnRegistro($sqlstr, ["usercod" => $usercod]);
    }
    public static function crearUsuario(
        string $usercod,
        string $useremail,
        string $username,
        string $userpswd,
        string $userfching,
        string $userpswdest,
        string $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo

    ) {
        $insSql = "INSERT INTO usuario (usercod, useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, useractcod, userpswdchg, usertipo)
        values (:usercod, :useremail, :username, :userpswd, :userfching, :userpswdest, :userpswdexp, :userest, :useractcod, :userpswdchg, :usertipo);";

        $newInserData = [
            "usercod" => $usercod,
            "useremail" => $useremail,
            "username" => $username,
            "userpswd" => $userpswd,
            "userfching" => $userfching,
            "userpswdest" => $userpswdest,
            "userpswdexp" => $userpswdexp,
            "userest" => $userest,
            "useractcod" => $useractcod,
            "userpswdchg" => $userpswdchg,
            "usertipo" => $usertipo
        ];
        return self::executeNonQuery($insSql, $newInserData);
    }
    public static function actualizarUsuario(
        string $usercod,
        string $useremail,
        string $username,
        string $userpswd,
        string $userfching,
        string $userpswdest,
        string $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo

    ) {
        $upsSql = "UPDATE usuario SET useremail=:useremail, username=:username, userpswd=:userpswd, userfching=:userfching, userpswdest=:userpswdest, userpswdexp=:userpswdexp, userest=:userest, useractcod=:useractcod, userpswdchg=:userpswdchg, usertipo=:usertipo
        WHERE usercod=:usercod;";

        $newUpdateData = [
            "usercod" => $usercod,
            "useremail" => $useremail,
            "username" => $username,
            "userpswd" => $userpswd,
            "userfching" => $userfching,
            "userpswdest" => $userpswdest,
            "userpswdexp" => $userpswdexp,
            "userest" => $userest,
            "useractcod" => $useractcod,
            "userpswdchg" => $userpswdchg,
            "usertipo" => $usertipo
        ];
        return self::executeNonQuery($upsSql, $newUpdateData);
    }
    public static function eliminarUsuario(string $usercod)
    {
        $delSql = "DELETE FROM usuario WHERE usercod=:usercod;";
        $dealParams = [
            "usercod" => $usercod
        ];
        return self::executeNonQuery($delSql, $dealParams);
    }
}
