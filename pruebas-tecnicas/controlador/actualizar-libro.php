<?php
// 1. Incluimos el archivo de conexión para poder interactuar con la base de datos
include("../base-datos/conexion-base-datos.php");

// 2. Verificamos que los datos se hayan enviado mediante el método HTTP POST (seguridad del formulario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Capturamos en variables locales cada uno de los datos enviados desde el formulario modal
    $id_libro = $_POST['id_libro'];                   // ID del libro que se va a editar
    $titulo = $_POST['titulo'];                       // Nuevo título
    $id_autor = $_POST['id_autor'];                   // Nuevo ID del autor seleccionado
    $precio = $_POST['precio'];                       // Nuevo precio
    $descripcion = $_POST['descripcion'];             // Nueva descripción
    $imagen = $_POST['imagen'] ?? 'default.jpg';      // Imagen (si viene vacía, asigna 'default.jpg' por defecto)
    $id_clasificacion = $_POST['id_clasificacion'];   // Nuevo ID de clasificación
    $id_editorial = $_POST['id_editorial'];           // Nuevo ID de editorial
    $existencias = $_POST['existencias'];             // Nuevas existencias en inventario
    $id_genero = $_POST['id_genero'];                 // Nuevo ID de género

    try {
        // 4. Preparamos la sentencia SQL de actualización (UPDATE) usando marcadores (:nombre) 
        // para prevenir inyecciones SQL y proteger la base de datos
        $sql = "UPDATE tb_libros SET 
                titulo = :titulo, 
                id_autor = :id_autor, 
                precio = :precio, 
                descripcion = :descripcion, 
                imagen = :imagen, 
                id_clasificacion = :id_clasificacion, 
                id_editorial = :id_editorial, 
                existencias = :existencias, 
                id_genero = :id_genero 
                WHERE id_libro = :id_libro";
        
        // 5. Preparamos la consulta en PDO
        $stmt = $conexion->prepare($sql);
        
        // 6. Ejecutamos la consulta asociando de forma segura cada variable con su marcador correspondiente
        $stmt->execute([
            ':id_libro' => $id_libro,
            ':titulo' => $titulo,
            ':id_autor' => $id_autor,
            ':precio' => $precio,
            ':descripcion' => $descripcion,
            ':imagen' => $imagen,
            ':id_clasificacion' => $id_clasificacion,
            ':id_editorial' => $id_editorial,
            ':existencias' => $existencias,
            ':id_genero' => $id_genero
        ]);

        // 7. Si la actualización es exitosa, redirigimos al usuario de vuelta a la vista 
        // añadiendo un parámetro GET '?actualizado=1' para identificar el éxito
        header("Location: ../vista/vista-prueba.php?actualizado=1");
        
        // 8. Detenemos la ejecución del script para asegurar que la redirección ocurra inmediatamente
        exit();

    } catch (PDOException $e) {
        // 9. Si ocurre algún error durante la ejecución de la base de datos, 
        // lo atrapamos aquí y mostramos el mensaje detallado del error
        echo "Error al actualizar el libro: " . $e->getMessage();
    }
}
?>