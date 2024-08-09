<?php

namespace Dao\Estudiantes;

use Dao\Table;

class Estudiantes extends Table 
{
    public static function getAllEstudiantes()
    {
        $sqlstr = "SELECT * FROM estudiantecienciascomputacionales;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getEstudiante($id_estudiante)
    {
        $sqlstr = "SELECT * FROM estudiantecienciascomputacionales WHERE id_estudiante = :id_estudiante;";
        return self::obtenerUnRegistro($sqlstr, ["id_estudiante" => $id_estudiante]);
    }

    public static function getEstudianteWithFilet($nombre){
        $sqlstr = "SELECT * FROM estudiantecienciascomputacionales WHERE nombre like :nombre;";
        return self::obtenerUnRegistro($sqlstr, ["nombre" => "%".$nombre."%"]);
    }

    public static function insertEstudiante(
        string $nombre,
        string $apellido,
        int $edad,
        string $especialidad
    )
    {
        $sqlstr = "INSERT INTO estudiantecienciascomputacionales (nombre, apellido, edad, especialidad)
        VALUES (:nombre, :apellido, :edad, :especialidad);";
        return self::executeNonQuery($sqlstr,
            [
                "nombre" => $nombre,
                "apellido" => $apellido,
                "edad" => $edad,
                "especialidad" => $especialidad
            ]
        );
    }

    public static function updateEstudiante(
        string $nombre,
        string $apellido,
        int $edad,
        string $especialidad,
        int $id_estudiante
    )
    {
        $sqlstr = "UPDATE estudiantecienciascomputacionales SET nombre = :nombre, 
        apellido = :apellido, edad = :especialidad
        WHERE id_estudiantes = :id_estudiantes;";
        return self::executeNonQuery(
        $sqlstr,
            [
                "nombre" => $nombre,
                "apellido" => $apellido,
                "edad" => $edad,
                "especialidad" => $especialidad,
                "id_estudiante" => $id_estudiante
            ]
        );
    }

    public static function deleteEstudiante($id_estudiante)
    {
        $sqlstr = "DELETE FROM estudiantecienciascomputacionales WHERE id_estudiante = :id:estudiante;";
        return self::executeNonQuery($sqlstr, ["id_estudiante" => $id_estudiante]);
    }
}

?>