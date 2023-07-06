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
$correo = $_POST["correo"];
$contrasena = $_POST["contrasena"];

// Verificar las credenciales del usuario
$sql = "SELECT ID, Nombre FROM Usuario WHERE Correo = '$correo' AND Contraseña = '$contrasena'";

$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Inicio de sesión exitoso
    $row = $result->fetch_assoc();
    session_start();
    $_SESSION["usuario_id"] = $row["ID"];
    $_SESSION["usuario_nombre"] = $row["Nombre"];
    header("Location: menu.html"); // Redireccionar al menú
} else {
    // Credenciales incorrectas
    echo "Inicio de sesión fallido. Verifica tus credenciales.";
}

$conn->close();
?>
