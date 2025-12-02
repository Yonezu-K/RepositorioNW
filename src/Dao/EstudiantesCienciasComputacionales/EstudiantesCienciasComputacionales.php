<?php

namespace Dao\EstudiantesCienciasComputacionales;

use Dao\Table;
use DateTime;

class EstudiantesCienciasComputacionales extends Table
{
    public static function obtenerEstudiantes(): array
    {
        $sqlstr = "SELECT * from EstudianteCienciasComputacionales;";
        return self::obtenerRegistros($sqlstr, []);
    }
    public static function obtenerEstudiantePorCodigo(string $id_estudiante): array
    {
        $sqlstr = "SELECT * from EstudianteCienciasComputacionales where id_estudiante=:id_estudiante;";
        return self::obtenerUnRegistro($sqlstr, ["id_estudiante" => $id_estudiante]);
    }
    public static function crearEstudiante(
        string $id_estudiante,
        string $nombre,
        string $apellido,
        string $edad,
        string $especialidad
    ) {
        $insSql = "INSERT INTO EstudianteCienciasComputacionales (id_estudiante, nombre, apellido, edad, especialidad)
        values (:id_estudiante, :nombre, :apellido, :edad, :especialidad);";

        $newInserData = [
            "id_estudiante" => $id_estudiante,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "edad" => $edad,
            "descripcion" => $especialidad
        ];
        return self::executeNonQuery($insSql, $newInserData);
    }
    public static function actualizarEstudiante(
        string $id_estudiante,
        string $nombre,
        string $apellido,
        string $edad,
        string $especialidad
    ) {
        $upsSql = "UPDATE EstudianteCienciasComputacionales SET nombre=:nombre, apellido=:apellido, edad=:edad, especialidad=:especialidad
        WHERE id_estudiante=:id_estudiante;";

        $newUpdateData = [
            "id_estudiante" => $id_estudiante,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "edad" => $edad,
            "especialidad" => $especialidad
        ];
        return self::executeNonQuery($upsSql, $newUpdateData);
    }
    public static function eliminarEstudiante(string $id_estudiante)
    {
        $delSql = "DELETE FROM EstudianteCienciasComputacionales WHERE id_estudiante=:id_estudiante;";
        $dealParams = [
            "id_estudiante" => $id_estudiante
        ];
        return self::executeNonQuery($delSql, $dealParams);
    }
}
