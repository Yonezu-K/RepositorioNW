<?php

namespace Dao\IncidentesEstudiantiles;

use Dao\Table;
use DateTime;

class IncidentesEstudiantiles extends Table
{
    public static function obtenerIncidentes(): array
    {
        $sqlstr = "SELECT * from incidentes_estudiantiles;";
        return self::obtenerRegistros($sqlstr, []);
    }
    public static function obtenerIncidentesPorCodigo(string $id): array
    {
        $sqlstr = "SELECT * from incidentes_estudiantiles where id=:id;";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }
    public static function crearIncidentes(
        int $id,
        string $estudiante_nombre,
        string $fecha_incidente,
        string $tipo_incidente,
        string $descripcion,
        string $accion_tomada,
        string $estado
    ) {
        $insSql = "INSERT INTO incidentes_estudiantiles (id, estudiante_nombre, fecha_incidente, tipo_incidente, descripcion, accion_tomada, estado)
        values (:id, :estudiante_nombre, :fecha_incidente, :tipo_incidente, :descripcion, :accion_tomada, :estado);";

        $newInserData = [
            "id" => $id,
            "estudiante_nombre" => $estudiante_nombre,
            "fecha_incidente" => $fecha_incidente,
            "tipo_incidente" => $tipo_incidente,
            "descripcion" => $descripcion,
            "accion_tomada" => $accion_tomada,
            "estado" => $estado
        ];
        return self::executeNonQuery($insSql, $newInserData);
    }
    public static function actualizarIncidentes(
        int $id,
        string $estudiante_nombre,
        string $fecha_incidente,
        string $tipo_incidente,
        string $descripcion,
        string $accion_tomada,
        string $estado
    ) {
        $upsSql = "UPDATE incidentes_estudiantiles SET estudiante_nombre=:estudiante_nombre, fecha_incidente=:fecha_incidente, tipo_incidente=:tipo_incidente, descripcion=:descripcion, accion_tomada=:accion_tomada, estado=:estado
        WHERE id=:id;";

        $newUpdateData = [
            "id" => $id,
            "estudiante_nombre" => $estudiante_nombre,
            "fecha_incidente" => $fecha_incidente,
            "tipo_incidente" => $tipo_incidente,
            "descripcion" => $descripcion,
            "accion_tomada" => $accion_tomada,
            "estado" => $estado
        ];
        return self::executeNonQuery($upsSql, $newUpdateData);
    }
    public static function eliminarIncidentes(string $id)
    {
        $delSql = "DELETE FROM incidentes_estudiantiles WHERE id=:id;";
        $dealParams = [
            "id" => $id
        ];
        return self::executeNonQuery($delSql, $dealParams);
    }
}
