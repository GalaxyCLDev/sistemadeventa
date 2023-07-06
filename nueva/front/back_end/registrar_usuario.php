<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "prueba2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$nombre = $_POST["nombre"];
$contrasena = $_POST["contrasena"];
$correo = $_POST["correo"];

// Insertar los datos en la tabla Usuario
$sql = "INSERT INTO Usuario (Nombre, Contraseña, Correo, FechaCreacion) VALUES ('$nombre', '$contrasena', '$correo', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado exitosamente";
} else {
    echo "Error al registrar el usuario: " . $conn->error;
}

$conn->close();
?>
