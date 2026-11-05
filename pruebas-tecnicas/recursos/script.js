// Seleccionamos y guardamos en constantes el elemento del DOM correspondiente al modal de agregar libro
const modalAgregar = document.getElementById('modalAgregar');

// Seleccionamos y guardamos en constantes el elemento del DOM correspondiente al modal de editar libro
const modalEditar = document.getElementById('modalEditar');

// Función que se encarga de mostrar el modal de agregar cambiando su propiedad display a 'flex'
function abrirModalAgregar() {
    modalAgregar.style.display = 'flex';
}

// Función que se encarga de ocultar el modal de agregar cambiando su propiedad display a 'none'
function cerrarModalAgregar() {
    modalAgregar.style.display = 'none';
}

// Función que abre el modal de edición y recibe como parámetro el botón (lápiz) que fue presionado en la fila
function abrirModalEditar(button) {
    // Obtenemos el valor del atributo data-id del botón y lo colocamos en el input oculto del formulario de edición
    document.getElementById('edit_id_libro').value = button.getAttribute('data-id');
    
    // Obtenemos el título del libro desde el atributo data-titulo y lo asignamos al campo de texto correspondiente
    document.getElementById('edit_titulo').value = button.getAttribute('data-titulo');
    
    // Obtenemos el ID del autor desde el atributo data-autor y seleccionamos la opción correcta en el selector desplegable
    document.getElementById('edit_id_autor').value = button.getAttribute('data-autor');
    
    // Obtenemos el precio del libro desde el atributo data-precio y lo insertamos en el campo numérico
    document.getElementById('edit_precio').value = button.getAttribute('data-precio');
    
    // Obtenemos las existencias desde el atributo data-existencias y las colocamos en su campo respectivo
    document.getElementById('edit_existencias').value = button.getAttribute('data-existencias');
    
    // Obtenemos el ID del género desde el atributo data-genero y lo fijamos en el menú desplegable del modal de editar
    document.getElementById('edit_id_genero').value = button.getAttribute('data-genero');
    
    // Obtenemos el ID de la clasificación desde el atributo data-clasificacion y actualizamos el selector correspondiente
    document.getElementById('edit_id_clasificacion').value = button.getAttribute('data-clasificacion');
    
    // Obtenemos el ID de la editorial desde el atributo data-editorial y seleccionamos la opción correcta
    document.getElementById('edit_id_editorial').value = button.getAttribute('data-editorial');
    
    // Obtenemos el nombre de la imagen desde el atributo data-imagen y lo rellenamos en su caja de texto
    document.getElementById('edit_imagen').value = button.getAttribute('data-imagen');
    
    // Obtenemos la descripción del libro desde el atributo data-descripcion y la colocamos en el campo de texto
    document.getElementById('edit_descripcion').value = button.getAttribute('data-descripcion');

    // Finalmente, cambiamos la propiedad display del modal de editar a 'flex' para que sea visible en la pantalla
    modalEditar.style.display = 'flex';
}

// Función que se encarga de ocultar el modal de editar cambiando su propiedad display a 'none'
function cerrarModalEditar() {
    modalEditar.style.display = 'none';
}

// Evento global en la ventana para cerrar los modales si el usuario hace clic fuera del contenido principal (la caja blanca)
window.onclick = function(event) {
    // Si el objetivo del clic fue exactamente el fondo oscuro del modal de agregar, se ejecuta la función de cierre
    if (event.target == modalAgregar) {
        cerrarModalAgregar();
    }
    // Si el objetivo del clic fue el fondo oscuro del modal de editar, se ejecuta su función de cierre
    if (event.target == modalEditar) {
        cerrarModalEditar();
    }
}