<?php
// Incluimos la conexión a la base de datos
include("../base-datos/conexion-base-datos.php");

try {
    // 1. Consultar los libros haciendo JOIN para obtener los nombres reales en lugar de los IDs
    $sql_libros = "SELECT l.*, 
                          a.nombre AS autor_nombre, 
                          g.nombre AS genero_nombre, 
                          c.nombre AS clasificacion_nombre, 
                          e.nombre AS editorial_nombre 
                   FROM tb_libros AS l
                   LEFT JOIN tb_autores AS a ON l.id_autor = a.id_autor
                   LEFT JOIN tb_generos AS g ON l.id_genero = g.id_genero
                   LEFT JOIN tb_clasificaciones AS c ON l.id_clasificacion = c.id_clasificacion
                   LEFT JOIN tb_editoriales AS e ON l.id_editorial = e.id_editorial";
                   
    $query_libros = $conexion->query($sql_libros);
    $libros = $query_libros->fetchAll(PDO::FETCH_ASSOC);

    // 2. Consultar los datos para llenar los ComboBox (Listas desplegables del Modal)
    $autores = $conexion->query("SELECT id_autor, nombre FROM tb_autores")->fetchAll(PDO::FETCH_ASSOC);
    $generos = $conexion->query("SELECT id_genero, nombre FROM tb_generos")->fetchAll(PDO::FETCH_ASSOC);
    $clasificaciones = $conexion->query("SELECT id_clasificacion, nombre FROM tb_clasificaciones")->fetchAll(PDO::FETCH_ASSOC);
    $editoriales = $conexion->query("SELECT id_editorial, nombre FROM tb_editoriales")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $libros = [];
    $autores = [];
    $generos = [];
    $clasificaciones = [];
    $editoriales = [];
    echo "Error al cargar los datos: " . $e->getMessage();
}
?>