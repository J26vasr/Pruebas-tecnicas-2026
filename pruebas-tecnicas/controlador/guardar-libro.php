<?php
// 1. Incluimos el archivo de conexión para poder comunicarnos con la base de datos
include("../base-datos/conexion-base-datos.php");

// 2. Verificamos que la petición se haya realizado mediante el método HTTP POST (cuando se envía el formulario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Capturamos en variables locales todos los datos enviados desde los campos del formulario modal
    $titulo = $_POST['titulo'];                       // Título del libro
    $id_autor = $_POST['id_autor'];                   // ID del autor seleccionado en el combobox
    $precio = $_POST['precio'];                       // Precio del libro
    $descripcion = $_POST['descripcion'];             // Descripción detallada
    $imagen = $_POST['imagen'] ?? 'default.jpg';      // Nombre de la imagen (si está vacío, se asigna 'default.jpg' por defecto)
    $id_clasificacion = $_POST['id_clasificacion'];   // ID de la clasificación seleccionada
    $id_editorial = $_POST['id_editorial'];           // ID de la editorial seleccionada
    $existencias = $_POST['existencias'];             // Cantidad disponible en stock
    $id_genero = $_POST['id_genero'];                 // ID del género seleccionado

    try {
        // 4. Definimos la consulta SQL de inserción (INSERT INTO) especificando las columnas 
        // y utilizando marcadores con dos puntos (:nombre) para prevenir inyecciones SQL
        $sql = "INSERT INTO tb_libros (titulo, id_autor, precio, descripcion, imagen, id_clasificacion, id_editorial, existencias, id_genero) 
                VALUES (:titulo, :id_autor, :precio, :descripcion, :imagen, :id_clasificacion, :id_editorial, :existencias, :id_genero)";
        
        // 5. Preparamos la consulta SQL utilizando la conexión PDO
        $stmt = $conexion->prepare($sql);
        
        // 6. Ejecutamos la consulta asociando de manera segura cada marcador con su variable correspondiente
        $stmt->execute([
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

        // 7. Si el registro se guarda correctamente, redirigimos al usuario de vuelta a la vista 
        // añadiendo el parámetro '?exito=1' en la URL
        header("Location: ../vista/vista-prueba.php?exito=1");
        
        // 8. Detenemos la ejecución inmediata del script para garantizar que la redirección funcione correctamente
        exit();

    } catch (PDOException $e) {
        // 9. Si ocurre algún error en la base de datos (por ejemplo, fallo de sintaxis o conexión), 
        // lo capturamos aquí y mostramos el mensaje detallado del error
        echo "Error al guardar el libro: " . $e->getMessage();
    }
}
?>