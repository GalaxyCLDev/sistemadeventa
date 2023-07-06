<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Ventas</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #f2f2f2;
    }

    h1 {
      color: #333;
    }

    table {
      margin: 20px auto;
      border-collapse: collapse;
      width: 80%;
    }

    th, td {
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    th {
      background-color: #4CAF50;
      color: white;
    }

    a {
      display: inline-block;
      background-color: #ccc;
      color: #333;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      margin-top: 10px;
    }

    a:hover {
      background-color: #999;
    }
  </style>
</head>
<body>
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

// Consultar las ventas
$sql = "SELECT VentaID, ProductoID, ProductoCodigo, ProductoNombre, ProductoPrecio, FechaVenta FROM Venta";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Ventas</h1>";
    echo "<table>";
    echo "<tr><th>VentaID</th><th>ProductoID</th><th>ProductoCodigo</th><th>ProductoNombre</th><th>ProductoPrecio</th><th>FechaVenta</th></tr>";

    $totalPrecio = 0; // Variable para almacenar la suma de ProductoPrecio

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["VentaID"] . "</td>";
        echo "<td>" . $row["ProductoID"] . "</td>";
        echo "<td>" . $row["ProductoCodigo"] . "</td>";        
        echo "<td>" . $row["ProductoNombre"] . "</td>";
        echo "<td>" . $row["ProductoPrecio"] . "</td>";
        echo "<td>" . $row["FechaVenta"] . "</td>";
        echo "</tr>";

        // Sumar el valor de ProductoPrecio al totalPrecio
        $totalPrecio += $row["ProductoPrecio"];
    }

    echo "</table>";
    echo "<p>Valor total de ProductoPrecio: " . $totalPrecio . "</p>";

    // Agregar enlace para volver atrás
    echo "<a href='javascript:history.back()'>Volver atrás</a>";
} else {
    echo "<p>No se encontraron ventas.</p>";
}

$conn->close();
?>
</body>
</html>
