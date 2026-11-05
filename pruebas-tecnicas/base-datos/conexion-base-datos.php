<?php
// 1. Definimos la dirección del servidor de base de datos (en este caso, tu propia computadora)
$host = "127.0.0.1";

// 2. Almacenamos el nombre de la base de datos a la que nos queremos conectar
$dbname = "powerletters"; 

// 3. Indicamos el nombre de usuario de la base de datos (por defecto en servidores locales es 'root')
$username = "root";

// 4. Contraseña del usuario (usualmente va vacía si usas XAMPP o entornos locales de prueba)
$password = ""; 

// 5. Puerto de comunicación predeterminado para MySQL / MariaDB
$port = "3306";

try {
    // 6. Intentamos crear una nueva instancia (conexión) de PDO usando los datos anteriores
    // Se incluye utf8mb4 para soportar acentos, emojis y caracteres especiales correctamente
    $conexion = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // 7. Configuramos PDO para que lance excepciones (errores detallados) si algo falla en las consultas
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 8. Si la conexión se crea con éxito, mostramos este mensaje en pantalla
    echo "¡Conexión exitosa a la base de datos!";

} catch (PDOException $e) {
    // 9. Si ocurre algún error (mal usuario, base de datos inexistente, etc.), 
    // el código salta aquí y captura el error sin romper la página
    echo "Error de conexión: " . $e->getMessage();
}
?>