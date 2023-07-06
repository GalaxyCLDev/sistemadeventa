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
$codigo = $_POST["codigo"];
$nombre = $_POST["nombre"];
$precio = $_POST["precio"];
$stock = $_POST["stock"];

// Obtener los datos de la imagen
$imagen = $_FILES["imagen"]["tmp_name"];
$imagen_tipo = $_FILES["imagen"]["type"];

// Convertir la imagen en datos binarios
$imagen_binaria = file_get_contents($imagen);

// Escapar caracteres especiales en los datos
$codigo = $conn->real_escape_string($codigo);
$nombre = $conn->real_escape_string($nombre);

// Crear una sentencia preparada
$sql = "INSERT INTO Producto (ProductoCodigo, ProductoNombre, ProductoPrecio, ProductoStock, ProductoImagen) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdis", $codigo, $nombre, $precio, $stock, $imagen_binaria);

// Ejecutar la sentencia preparada
if ($stmt->execute()) {
    echo "Producto registrado exitosamente";
} else {
    echo "Error al registrar el producto: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
