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

// Verificar si se solicita cerrar sesión
if (isset($_GET['logout'])) {
    // Destruir todas las variables de sesión
    session_start();
    session_unset();
    session_destroy();

    // Redirigir al inicio de sesión
    header("Location: inicio_sesion.html");
    exit();
}

// Recibir los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Validar y limpiar los datos de entrada
    $correo = mysqli_real_escape_string($conn, $correo);

    // Verificar las credenciales del usuario utilizando sentencias preparadas
    $sql = "SELECT ID, Nombre FROM Usuario WHERE Correo = ? AND Contraseña = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $correo, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Inicio de sesión exitoso
        $row = $result->fetch_assoc();
        session_start();
        $_SESSION["usuario_id"] = $row["ID"];
        $_SESSION["usuario_nombre"] = $row["Nombre"];
        header("Location: menu.html"); // Redireccionar al menú
        exit();
    } else {
        // Credenciales incorrectas
        $error_message = "Inicio de sesión fallido. Verifica tus credenciales.";
        // Redirigir a una página de error o mostrar el mensaje de error en una plantilla de vista
        // ...
    }

    $stmt->close();
}

$conn->close();
?>
