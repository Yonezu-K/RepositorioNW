<?php

namespace Dao\Clientes;

use Dao\Table;

class Clientes extends Table
{
    public static function obtenerCLientes(): array
    {
        $sqlstr = "SELECT * from clientes;";
        return self::obtenerRegistros($sqlstr, []);
    }
    public static function obtenerCLientePorCodigo(string $codigo): array
    {
        $sqlstr = "SELECT * from clientes where codigo=:codigo;";
        return self::obtenerUnRegistro($sqlstr, ["codigo" => $codigo]);
    }
    public static function crearCliente(
        string $codigo,
        string $nombre,
        string $direccion,
        string $telefono,
        string $correo,
        string $estado,
        int $evaluacion
    ) {
        $insSql = "INSERT INTO clientes (codigo, nombre, direccion, telefono, correo, estado, evaluacion)
        values (:codigo, :nombre, :direccion, :telefono, :correo, :estado, :evaluacion);";

        $newInserData = [
            "codigo" => $codigo,
            "nombre" => $nombre,
            "direccion" => $direccion,
            "telefono" => $telefono,
            "correo" => $correo,
            "estado" => $estado,
            "evaluacion" => $evaluacion
        ];
        return self::executeNonQuery($insSql, $newInserData);
    }
    public static function actualizarCliente(
        string $codigo,
        string $nombre,
        string $direccion,
        string $telefono,
        string $correo,
        string $estado,
        int $evaluacion
    ) {
        $upsSql = "UPDATE clientes SET nombre=:nombre, direccion=:direccion, telefono=:telefono, correo=:correo, estado=:estado, evaluacion=:evaluacion
        WHERE codigo=:codigo;";

        $newUpdateData = [
            "codigo" => $codigo,
            "nombre" => $nombre,
            "direccion" => $direccion,
            "telefono" => $telefono,
            "correo" => $correo,
            "estado" => $estado,
            "evaluacion" => $evaluacion
        ];
        return self::executeNonQuery($upsSql, $newUpdateData);
    }
    public static function eliminarCliente(string $codigo)
    {
        $delSql = "DELETE FROM clientes WHERE codigo=:codigo;";
        $dealParams = [
            "codigo" => $codigo
        ];
        return self::executeNonQuery($delSql, $dealParams);
    }
}
