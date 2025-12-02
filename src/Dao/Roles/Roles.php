<?php

namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{
    public static function obtenerRol(): array
    {
        $sqlstr = "SELECT * from roles;";
        return self::obtenerRegistros($sqlstr, []);
    }
    public static function obtenerRolPorCodigo(string $rolescod): array
    {
        $sqlstr = "SELECT * from roles where rolescod=:rolescod;";
        return self::obtenerUnRegistro($sqlstr, ["rolescod" => $rolescod]);
    }
    public static function crearRol(
        string $rolescod,
        string $rolesdsc,
        string $rolesest

    ) {
        $insSql = "INSERT INTO roles (rolescod, rolesdsc, rolesest)
        values (:rolescod, :rolesdsc, :rolesest);";

        $newInserData = [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ];
        return self::executeNonQuery($insSql, $newInserData);
    }
    public static function actualizarRol(
        string $rolescod,
        string $rolesdsc,
        string $rolesest

    ) {
        $upsSql = "UPDATE roles SET rolescod=:rolescod, rolesdsc=:rolesdsc, rolesest=:rolesest
        WHERE rolescod=:rolescod;";

        $newUpdateData = [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ];
        return self::executeNonQuery($upsSql, $newUpdateData);
    }
    public static function eliminarRol(string $rolescod)
    {
        $delSql = "DELETE FROM roles WHERE rolescod=:rolescod;";
        $dealParams = [
            "rolescod" => $rolescod
        ];
        return self::executeNonQuery($delSql, $dealParams);
    }
}
