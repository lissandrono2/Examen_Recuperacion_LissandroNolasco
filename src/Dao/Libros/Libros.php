<?php

namespace Dao\Libros;

use Dao\Table;

class Libros extends Table
{
    // getAll
    public static function getAll()
    {
        return self::obtenerRegistros("SELECT * FROM libros", []);
    }
    // getById
    public static function getById($id)
    {
        return self::obtenerUnRegistro("SELECT * FROM libros WHERE libros_id = :id", ["id" => $id]);
    }
    // Add
    public static function add(
        $libros_dsc,
        $libros_isbn,
        $libros_autor,
        $libros_categoria,
        $libros_estado
    ) {
        $insertSql = "INSERT INTO libros (libros_dsc, libros_isbn, libros_autor, libros_categoria, libros_estado) VALUES (:libros_dsc, :libros_isbn, :libros_autor, :libros_categoria, :libros_estado)";
        return self::executeNonQuery($insertSql, [
            "libros_dsc" => $libros_dsc,
            "libros_isbn" => $libros_isbn,
            "libros_autor" => $libros_autor,
            "libros_categoria" => $libros_categoria,
            "libros_estado" => $libros_estado
        ]);
    }
    // Update
    public static function update(
        $libros_dsc,
        $libros_isbn,
        $libros_autor,
        $libros_categoria,
        $libros_estado,
        $libros_id
    ) {
        $updateSql = "UPDATE libros SET libros_dsc = :libros_dsc, libros_isbn = :libros_isbn, libros_autor = :libros_autor, libros_categoria = :libros_categoria, libros_estado = :libros_estado WHERE libros_id = :libros_id";
        return self::executeNonQuery($updateSql, [
            "libros_dsc" => $libros_dsc,
            "libros_isbn" => $libros_isbn,
            "libros_autor" => $libros_autor,
            "libros_categoria" => $libros_categoria,
            "libros_estado" => $libros_estado,
            "libros_id" => $libros_id
        ]);
    }
    // Delete
    public static function delete($id)
    {
        $deleteSql = "DELETE FROM libros WHERE libros_id = :libros_id";
        return self::executeNonQuery($deleteSql, ["libros_id" => $id]);
    }
}
