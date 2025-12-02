<?php

namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
    public static function obtenerFunciones(): array
    {
        $sqlstr = "SELECT * from funciones;";
        return self::obtenerRegistros($sqlstr, []);
    }
    public static function obtenerFuncionesPorCodigo(string $fncod): array
    {
        $sqlstr = "SELECT * from funciones where fncod=:fncod;";
        return self::obtenerUnRegistro($sqlstr, ["fncod" => $fncod]);
    }
    public static function crearFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp

    ) {
        $insSql = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp)
        values (:fncod, :fndsc, :fnest, :fntyp);";

        $newInserData = [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ];
        return self::executeNonQuery($insSql, $newInserData);
    }
    public static function actualizarFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $upsSql = "UPDATE funciones SET fncod=:fncod, fndsc=:fndsc, fnest=:fnest, fntyp=:fntyp
        WHERE fncod=:fncod;";

        $newUpdateData = [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ];
        return self::executeNonQuery($upsSql, $newUpdateData);
    }
    public static function eliminarFuncion(string $fncod)
    {
        $delSql = "DELETE FROM funciones WHERE fncod=:fncod;";
        $dealParams = [
            "fncod" => $fncod
        ];
        return self::executeNonQuery($delSql, $dealParams);
    }
}
