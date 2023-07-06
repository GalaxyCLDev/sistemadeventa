<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        h1 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            display: inline;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        a {
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php
    // Definir los detalles de la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "prueba2";

    // Establecer la conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar si se ha enviado una solicitud de eliminación
    if (isset($_GET['delete_id']) && isset($_GET['quantity'])) {
        $deleteId = $_GET['delete_id'];
        $quantity = $_GET['quantity'];

        // Verificar si el producto existe
        $checkSql = "SELECT ProductoStock FROM Producto WHERE ProductoID = $deleteId";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            $row = $checkResult->fetch_assoc();
            $currentStock = $row['ProductoStock'];

            // Verificar si la cantidad a eliminar es válida
            if ($quantity <= $currentStock) {
                $newStock = $currentStock - $quantity;
                $updateSql = "UPDATE Producto SET ProductoStock = $newStock WHERE ProductoID = $deleteId";

                if ($conn->query($updateSql) === TRUE) {
                    echo "Se han eliminado $quantity unidades del producto exitosamente.";
                } else {
                    echo "Error al actualizar el stock del producto: " . $conn->error;
                }
            } else {
                echo "La cantidad a eliminar es mayor que el stock actual del producto.";
            }
        } else {
            echo "El producto no existe.";
        }
    }

    // Consultar los productos
    $sql = "SELECT ProductoID, ProductoCodigo, ProductoNombre, ProductoPrecio, ProductoStock, ProductoImagen FROM Producto";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h1>Productos</h1>";
        echo "<table>";
        echo "<tr><th>ProductoID</th><th>ProductoCodigo</th><th>ProductoNombre</th><th>ProductoPrecio</th><th>ProductoStock</th><Aquí tienes el resto del código PHP con los estilos CSS agregados:

```php
ProductoImagen</th><th>Eliminar Stock</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ProductoID"] . "</td>";
            echo "<td>" . $row["ProductoCodigo"] . "</td>";
            echo "<td>" . $row["ProductoNombre"] . "</td>";
            echo "<td>" . $row["ProductoPrecio"] . "</td>";
            echo "<td>" . $row["ProductoStock"] . "</td>";
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($row["ProductoImagen"]) . "' width='100' height='100' alt='Imagen del producto'></td>";
            echo "<td>";
            echo "<form action='' method='GET'>";
            echo "<input type='hidden' name='delete_id' value='" . $row["ProductoID"] . "'>";
            echo "<input type='number' name='quantity' min='1' max='" . $row["ProductoStock"] . "' required>";
            echo "<button type='submit' class='button'>Eliminar</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron productos.";
    }

    // Agregar enlace para volver atrás
    echo "<a href='javascript:history.back()'>Volver atrás</a>";

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
