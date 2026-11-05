const modalAgregar = document.getElementById('modalAgregar');
const modalEditar = document.getElementById('modalEditar');

function abrirModalAgregar() {
    modalAgregar.style.display = 'flex';
}

function cerrarModalAgregar() {
    modalAgregar.style.display = 'none';
}

function abrirModalEditar(button) {
    // Obtenemos los datos desde los atributos data-* del botón de la fila
    document.getElementById('edit_id_libro').value = button.getAttribute('data-id');
    document.getElementById('edit_titulo').value = button.getAttribute('data-titulo');
    document.getElementById('edit_id_autor').value = button.getAttribute('data-autor');
    document.getElementById('edit_precio').value = button.getAttribute('data-precio');
    document.getElementById('edit_existencias').value = button.getAttribute('data-existencias');
    document.getElementById('edit_id_genero').value = button.getAttribute('data-genero');
    document.getElementById('edit_id_clasificacion').value = button.getAttribute('data-clasificacion');
    document.getElementById('edit_id_editorial').value = button.getAttribute('data-editorial');
    document.getElementById('edit_imagen').value = button.getAttribute('data-imagen');
    document.getElementById('edit_descripcion').value = button.getAttribute('data-descripcion');

    modalEditar.style.display = 'flex';
}

function cerrarModalEditar() {
    modalEditar.style.display = 'none';
}

// Cerrar modales si se hace clic fuera de la caja blanca
window.onclick = function(event) {
    if (event.target == modalAgregar) {
        cerrarModalAgregar();
    }
    if (event.target == modalEditar) {
        cerrarModalEditar();
    }
}