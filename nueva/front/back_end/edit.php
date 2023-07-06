<?php
include 'conexion.php';
?>



if (isset($_GET['id'])) {
    $editId = $_GET['id'];

    // Obtener los datos del proveedor a editar
    $editSql = "SELECT * FROM proveedor WHERE ProveedorID = $editId";
    $editResult = $conn->query($editSql);
    $editRow = $editResult->fetch_assoc();

    // Mostrar el formulario de edición
    echo "<h2>Editar Proveedor</h2>";
    echo "<form method='post' action=''>";
    echo "<input type='hidden' name='editId' value='" . $editRow["ProveedorID"] . "'>";
    echo "<label for='nombre'>Nombre:</label>";
    echo "<input type='text' name='editNombre' value='" . $editRow["Nombre"] . "' required><br><br>";
    echo "<label for='direccion'>Dirección:</label>";
    echo "<input type='text' name='editDireccion' value='" . $editRow["Direccion"] . "' required><br><br>";
    echo "<label for='telefono'>Teléfono:</label>";
    echo "<input type='text' name='editTelefono' value='" . $editRow["Telefono"] . "' required><br><br>";
    echo "<input type='submit' name='actualizar' value='Actualizar Proveedor'>";
    echo "</form>";
}
?>

<?php
if (isset($_POST['actualizar'])) {
    $editId = $_POST['editId'];
    $editNombre = $_POST['editNombre'];
    $editDireccion = $_POST['editDireccion'];
    $editTelefono = $_POST['editTelefono'];

    // Actualizar los datos del proveedor en la base de datos
    $updateSql = "UPDATE proveedor SET Nombre = '$editNombre', Direccion = '$editDireccion', Telefono = '$editTelefono' WHERE ProveedorID = $editId";
    if ($conn->query($updateSql) === TRUE) {
        echo "Proveedor actualizado exitosamente.";
    } else {
        echo "Error al actualizar el proveedor: " . $conn->error;
    }
}
