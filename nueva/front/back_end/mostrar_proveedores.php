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

// Verificar si se ha enviado un ID de proveedor para eliminar
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];

    // Eliminar el proveedor de la base de datos
    $deleteSql = "DELETE FROM proveedor WHERE ProveedorID = $deleteId";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Proveedor eliminado exitosamente.";
    } else {
        echo "Error al eliminar el proveedor: " . $conn->error;
    }
}

// Obtener la lista de proveedores
$sql = "SELECT * FROM proveedor";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Lista de Proveedores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
        }

        h2 {
            color: #333;
        }

        table {
            width: 600px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        table th,
        table td {
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #333;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #333;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h2>Lista de Proveedores</h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Acciones</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ProveedorID"] . "</td>";
            echo "<td>" . $row["Nombre"] . "</td>";
            echo "<td>" . $row["Direccion"] . "</td>";
            echo "<td>" . $row["Telefono"] . "</td>";
            echo "<td><a href='?delete=" . $row["ProveedorID"] . "'>Eliminar</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron proveedores.";
    }
    ?>

    <?php
    // Agregar enlace para volver atrás
    echo "<a href='javascript:history.back()'>Volver atrás</a>";
    // Cerrar la conexión a la base de datos
    echo "<td><a href='edit.php?id=" . $row["ProveedorID"] . "'>Editar</a> | <a href='?delete=" . $row["ProveedorID"] . "'>Eliminar</a></td>";

    $conn->close();
    ?>
</body>
