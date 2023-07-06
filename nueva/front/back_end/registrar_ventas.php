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

// Procesar la solicitud de venta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el código de barras del formulario
    $barcode = trim($_POST["barcode"]); // Elimina espacios en blanco al principio y al final del código de barras
    $fechaVenta = date("Y-m-d H:i:s");

    $productoQuery = "SELECT ProductoID, ProductoCodigo, ProductoNombre, ProductoPrecio, ProductoStock FROM producto WHERE ProductoCodigo LIKE ?";
    $stmt = $conn->prepare($productoQuery);
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $productoResult = $stmt->get_result();

    if ($productoResult->num_rows > 0) {
        $row = $productoResult->fetch_assoc();
        $productoID = $row["ProductoID"];
        $productoCodigo = $row["ProductoCodigo"];
        $productoNombre = $row["ProductoNombre"];
        $productoPrecio = $row["ProductoPrecio"];
        $cantidadActual = $row["ProductoStock"];

        $cantidadVendida = 1; // Cambia esto según tu lógica de venta
        $nuevaCantidad = $cantidadActual - $cantidadVendida;

        // Actualiza el stock del producto en la tabla 'producto'
        $actualizarStockQuery = "UPDATE producto SET ProductoStock = ? WHERE ProductoID = ?";
        $stmt = $conn->prepare($actualizarStockQuery);
        $stmt->bind_param("ii", $nuevaCantidad, $productoID);
        if ($stmt->execute()) {
            echo "Venta registrada correctamente. Stock actualizado.";
        } else {
            echo "Error al registrar la venta y actualizar el stock: " . $conn->error;
        }

        // Insertar la venta en la tabla 'venta'
        $insertQuery = "INSERT INTO venta (ProductoID, ProductoCodigo, ProductoNombre, ProductoPrecio, FechaVenta) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("issss", $productoID, $productoCodigo, $productoNombre, $productoPrecio, $fechaVenta);
        if ($stmt->execute()) {
            echo "Venta registrada correctamente.";
        } else {
            echo "Error al registrar la venta: " . $conn->error;
        }
    } else {
        echo "Producto no encontrado.";
    }

    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Venta de Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
        }

        h2 {
            color: #333;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        input[type="text"] {
            width: 100%;
            padding:10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            color: #333;
            text-decoration: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    var barcode = $("#barcode").val();
                    $("#barcode").val('');
                    $("#barcode").focus();
                    $("form").submit();
                }
            });
        });
    </script>
</head>
<body>
    <h2>Escanea el código de barras:</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" id="barcode" name="barcode" placeholder="Escanea el código de barras" autofocus>
        <br><br>
        <input type="submit" value="Vender">
    </form>

    <?php
    // Agregar enlace para volver atrás
    echo "<a href='javascript:history.back()'>Volver atrás</a>";
    ?>
</body>
</html>
