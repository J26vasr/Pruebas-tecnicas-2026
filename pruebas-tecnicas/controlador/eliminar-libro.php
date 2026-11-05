<?php
include("../base-datos/conexion-base-datos.php");

if (isset($_GET['id'])) {
    $id_libro = $_GET['id'];

    try {
        // Iniciamos una transacción para asegurar que todo se borre correctamente o nada
        $conexion->beginTransaction();

        // 1. Borrar los comentarios asociados a los detalles del pedido de este libro
        $sql_comentarios = "DELETE c FROM tb_comentarios AS c 
                            INNER JOIN tb_detalle_pedidos AS dp ON c.id_detalle = dp.id_detalle 
                            WHERE dp.id_libro = :id_libro";
        $stmt = $conexion->prepare($sql_comentarios);
        $stmt->execute([':id_libro' => $id_libro]);

        // 2. Borrar los detalles de pedidos que contienen este libro
        $sql_detalles = "DELETE FROM tb_detalle_pedidos WHERE id_libro = :id_libro";
        $stmt = $conexion->prepare($sql_detalles);
        $stmt->execute([':id_libro' => $id_libro]);

        // 3. Finalmente, borrar el libro
        $sql_libro = "DELETE FROM tb_libros WHERE id_libro = :id_libro";
        $stmt = $conexion->prepare($sql_libro);
        $stmt->execute([':id_libro' => $id_libro]);

        // Confirmamos los cambios en la base de datos
        $conexion->commit();

        header("Location: ../vista/vista-prueba.php?eliminado=1");
        exit();

    } catch (PDOException $e) {
        // Si algo falla, revertimos los cambios
        $conexion->rollBack();
        echo "Error al eliminar el libro: " . $e->getMessage();
    }
}
?>