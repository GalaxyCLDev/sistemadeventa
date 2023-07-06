<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "prueba2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Procesar el formulario de registro de proveedores
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];

    // Insertar el proveedor en la tabla 'proveedor'
    $insertQuery = "INSERT INTO proveedor (Nombre, Direccion, Telefono) VALUES ('$nombre', '$direccion', '$telefono')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Proveedor registrado correctamente.";
    } else {
        echo "Error al registrar el proveedor: " . $conn->error;
    }
}
    // Agregar enlace para volver atrás
    echo "<a href='javascript:history.back()'>Volver atrás</a>";
// Cerrar la conexión a la base de datos
$conn->close();
?>
