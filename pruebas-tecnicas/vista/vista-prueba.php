<?php
// Incluye el archivo modelo que se encarga de obtener los datos de los libros, autores, géneros, etc., desde la base de datos.
include("../modelo/obtener-libros.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros - PowerLetters</title>
    <!-- Enlace a la hoja de estilos externa -->
    <link rel="stylesheet" href="../recursos/estilo.css">
</head>

<body>

    <div class="container">
        <h2>Catálogo de Libros - PowerLetters</h2>

        <!-- Botón para abrir el Modal de Añadir un nuevo registro -->
        <button class="btn-abrir-modal" onclick="abrirModalAgregar()">+ Añadir Nuevo Libro</button>

        <!-- ========================================== -->
        <!-- MODAL DE AGREGAR LIBRO -->
        <!-- ========================================== -->
        <div id="modalAgregar" class="modal">
            <div class="modal-content">
                <!-- Botón de cierre ("X") del modal -->
                <span class="close-btn" onclick="cerrarModalAgregar()">&times;</span>
                <h3 style="margin-top: 0; color: #2c3e50;">Registrar Nuevo Libro</h3>

                <!-- Formulario que envía los datos mediante método POST al archivo controlador para guardar el libro -->
                <form action="../controlador/guardar-libro.php" method="POST">
                    <div class="form-grid">
                        
                        <!-- Campo Título del libro -->
                        <div class="input-group">
                            <label for="titulo">Título</label>
                            <input type="text" id="titulo" name="titulo" required>
                        </div>

                        <!-- Selector de Autor cargado dinámicamente desde la base de datos con PHP -->
                        <div class="input-group">
                            <label for="id_autor">Autor</label>
                            <select id="id_autor" name="id_autor" required>
                                <option value="">Seleccione un autor...</option>
                                <?php foreach ($autores as $autor) { ?>
                                    <option value="<?php echo $autor['id_autor']; ?>"><?php echo htmlspecialchars($autor['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Campo Precio del libro -->
                        <div class="input-group">
                            <label for="precio">Precio ($)</label>
                            <input type="number" step="0.01" id="precio" name="precio" required>
                        </div>

                        <!-- Campo Existencias (stock disponible) -->
                        <div class="input-group">
                            <label for="existencias">Existencias</label>
                            <input type="number" id="existencias" name="existencias" required>
                        </div>

                        <!-- Selector de Género literario -->
                        <div class="input-group">
                            <label for="id_genero">Género</label>
                            <select id="id_genero" name="id_genero" required>
                                <option value="">Seleccione un género...</option>
                                <?php foreach ($generos as $genero) { ?>
                                    <option value="<?php echo $genero['id_genero']; ?>"><?php echo htmlspecialchars($genero['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Selector de Clasificación -->
                        <div class="input-group">
                            <label for="id_clasificacion">Clasificación</label>
                            <select id="id_clasificacion" name="id_clasificacion" required>
                                <option value="">Seleccione una clasificación...</option>
                                <?php foreach ($clasificaciones as $clasificacion) { ?>
                                    <option value="<?php echo $clasificacion['id_clasificacion']; ?>"><?php echo htmlspecialchars($clasificacion['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Selector de Editorial -->
                        <div class="input-group">
                            <label for="id_editorial">Editorial</label>
                            <select id="id_editorial" name="id_editorial" required>
                                <option value="">Seleccione una editorial...</option>
                                <?php foreach ($editoriales as $editorial) { ?>
                                    <option value="<?php echo $editorial['id_editorial']; ?>"><?php echo htmlspecialchars($editorial['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Campo Imagen con un valor por defecto ("default.jpg") -->
                        <div class="input-group">
                            <label for="imagen">Imagen</label>
                            <input type="text" id="imagen" name="imagen" value="default.jpg">
                        </div>

                        <!-- Campo Descripción que abarca dos columnas completas en la rejilla -->
                        <div class="input-group" style="grid-column: span 2;">
                            <label for="descripcion">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion">
                        </div>
                    </div>

                    <!-- Botón de envío del formulario de registro -->
                    <div style="text-align: right; margin-top: 20px;">
                        <button type="submit" class="btn-add">Guardar Libro</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL DE EDITAR LIBRO -->
        <!-- ========================================== -->
        <div id="modalEditar" class="modal">
            <div class="modal-content">
                <!-- Botón de cierre del modal de edición -->
                <span class="close-btn" onclick="cerrarModalEditar()">&times;</span>
                <h3 style="margin-top: 0; color: #2c3e50;">Editar Libro</h3>

                <!-- Formulario para actualizar el libro que se envía al controlador correspondiente -->
                <form action="../controlador/actualizar-libro.php" method="POST">
                    <!-- Campo oculto (hidden) que almacena el ID del libro que se está modificando -->
                    <input type="hidden" id="edit_id_libro" name="id_libro">

                    <div class="form-grid">
                        <!-- Título editable -->
                        <div class="input-group">
                            <label for="edit_titulo">Título</label>
                            <input type="text" id="edit_titulo" name="titulo" required>
                        </div>

                        <!-- Autor editable con opciones cargadas desde PHP -->
                        <div class="input-group">
                            <label for="edit_id_autor">Autor</label>
                            <select id="edit_id_autor" name="id_autor" required>
                                <option value="">Seleccione un autor...</option>
                                <?php foreach ($autores as $autor) { ?>
                                    <option value="<?php echo $autor['id_autor']; ?>"><?php echo htmlspecialchars($autor['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Precio editable -->
                        <div class="input-group">
                            <label for="edit_precio">Precio ($)</label>
                            <input type="number" step="0.01" id="edit_precio" name="precio" required>
                        </div>

                        <!-- Existencias editables -->
                        <div class="input-group">
                            <label for="edit_existencias">Existencias</label>
                            <input type="number" id="edit_existencias" name="existencias" required>
                        </div>

                        <!-- Género editable (corregido y limpio sin conflictos de sintaxis) -->
                        <div class="input-group">
                            <label for="edit_id_genero">Género</label>
                            <select id="edit_id_genero" name="id_genero" required>
                                <option value="">Seleccione un género...</option>
                                <?php foreach ($generos as $genero) { ?>
                                    <option value="<?php echo $genero['id_genero']; ?>"><?php echo htmlspecialchars($genero['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Clasificación editable -->
                        <div class="input-group">
                            <label for="edit_id_clasificacion">Clasificación</label>
                            <select id="edit_id_clasificacion" name="id_clasificacion" required>
                                <option value="">Seleccione una clasificación...</option>
                                <?php foreach ($clasificaciones as $clasificacion) { ?>
                                    <option value="<?php echo $clasificacion['id_clasificacion']; ?>"><?php echo htmlspecialchars($clasificacion['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Editorial editable -->
                        <div class="input-group">
                            <label for="edit_id_editorial">Editorial</label>
                            <select id="edit_id_editorial" name="id_editorial" required>
                                <option value="">Seleccione una editorial...</option>
                                <?php foreach ($editoriales as $editorial) { ?>
                                    <option value="<?php echo $editorial['id_editorial']; ?>"><?php echo htmlspecialchars($editorial['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Imagen editable -->
                        <div class="input-group">
                            <label for="edit_imagen">Imagen</label>
                            <input type="text" id="edit_imagen" name="imagen">
                        </div>

                        <!-- Descripción editable que abarca dos columnas -->
                        <div class="input-group" style="grid-column: span 2;">
                            <label for="edit_descripcion">Descripción</label>
                            <input type="text" id="edit_descripcion" name="descripcion">
                        </div>
                    </div>

                    <!-- Botón para guardar los cambios de la edición -->
                    <div style="text-align: right; margin-top: 20px;">
                        <button type="submit" class="btn-update">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TABLA DE LISTADO DE REGISTROS -->
        <!-- ========================================== -->
        <h3>Lista de Registros</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Precio</th>
                    <th>Existencias</th>
                    <th>Género</th>
                    <th>Clasificación</th>
                    <th>Editorial</th>
                    <th>Descripción</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($libros)) { ?>
                    <!-- Recorremos cada libro obtenido de la base de datos -->
                    <?php foreach ($libros as $libro) { ?>
                        <tr>
                            <!-- Mostramos los campos de cada registro en su respectiva celda -->
                            <td><?php echo $libro['id_libro']; ?></td>
                            <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($libro['autor_nombre'] ?? 'Sin autor'); ?></td>
                            <td>$<?php echo number_format($libro['precio'], 2); ?></td>
                            <td><?php echo $libro['existencias']; ?></td>
                            <td><?php echo htmlspecialchars($libro['genero_nombre'] ?? 'Sin género'); ?></td>
                            <td><?php echo htmlspecialchars($libro['clasificacion_nombre'] ?? 'Sin clasificación'); ?></td>
                            <td><?php echo htmlspecialchars($libro['editorial_nombre'] ?? 'Sin editorial'); ?></td>
                            <td><?php echo htmlspecialchars($libro['descripcion']); ?></td>
                            
                            <!-- Celda de acciones (botones de editar y eliminar) -->
                            <td style="text-align: center; white-space: nowrap;">
                                <!-- Botón de Lápiz para Editar: Envía los atributos data-* para cargarlos dinámicamente al modal mediante JavaScript -->
                                <button class="btn-editar"
                                    onclick="abrirModalEditar(this)"
                                    data-id="<?php echo $libro['id_libro']; ?>"
                                    data-titulo="<?php echo htmlspecialchars($libro['titulo']); ?>"
                                    data-autor="<?php echo $libro['id_autor']; ?>"
                                    data-precio="<?php echo $libro['precio']; ?>"
                                    data-existencias="<?php echo $libro['existencias']; ?>"
                                    data-genero="<?php echo $libro['id_genero']; ?>"
                                    data-clasificacion="<?php echo $libro['id_clasificacion']; ?>"
                                    data-editorial="<?php echo $libro['id_editorial']; ?>"
                                    data-imagen="<?php echo htmlspecialchars($libro['imagen']); ?>"
                                    data-descripcion="<?php echo htmlspecialchars($libro['descripcion']); ?>"
                                    title="Editar libro">
                                    ✏️
                                </button>

                                <!-- Botón de Basurero para Eliminar: Incluye una confirmación previa en JavaScript antes de proceder -->
                                <a href="../controlador/eliminar-libro.php?id=<?php echo $libro['id_libro']; ?>"
                                    class="btn-eliminar"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este libro?');"
                                    title="Eliminar libro">
                                    🗑️
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <!-- Fila por defecto si la base de datos no arroja ningún resultado -->
                    <tr>
                        <td colspan="10" style="text-align: center;">No hay libros registrados.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Archivo de JavaScript externo para controlar la apertura/cierre de modales y lógica de la interfaz -->
    <script src="../recursos/script.js"></script>

</body>

</html>