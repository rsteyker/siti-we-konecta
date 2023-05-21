<!DOCTYPE html>
<html>
<head>
  <title>Realizar venta</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Realizar venta</h1>
    
    <?php
    // Conexión a la base de datos
    require('../../config/database.php');

    // Verificar si se ha proporcionado un ID válido y una cantidad de venta
    if (isset($_GET['id']) && isset($_POST['cantidad'])) {
      $id = $_GET['id'];
      $cantidadVendida = $_POST['cantidad'];


      // Consultar el producto por ID
      $sqlProducto = "SELECT * FROM productos WHERE id = $id";
      $resultProducto = $conn->query($sqlProducto);

      if ($resultProducto->num_rows == 1) {
        $rowProducto = $resultProducto->fetch_assoc();
        $stockActual = $rowProducto['stock'];

        // Verificar si hay suficiente stock para la venta
        if ($stockActual > 0 && $stockActual >= $cantidadVendida) {
          // Actualizar el stock del producto
          $nuevoStock = $stockActual - $cantidadVendida;
          $sqlUpdateStock = "UPDATE productos SET stock = $nuevoStock WHERE id = $id";
          if ($conn->query($sqlUpdateStock) !== TRUE) {
            echo "Error al actualizar el stock del producto: " . $conn->error;
          }

          // Registrar la venta en la tabla de ventas
          $fechaVenta = date('Y-m-d');
          $sqlInsertVenta = "INSERT INTO ventas (id_Producto, cantidad, fecha_venta) VALUES ($id, $cantidadVendida, '$fechaVenta')";
          if ($conn->query($sqlInsertVenta) === TRUE) {
            echo "Venta realizada correctamente.";
          } else {
            echo "Error al registrar la venta: " . $conn->error;
          }
        } else {
          echo "No hay suficiente stock disponible para realizar la venta.";
        }
      } else {
        echo "No se encontró el producto.";
      }
      $conn->close();
    } else {
      echo "Debe proporcionar un ID de producto válido y una cantidad de venta.";
    }
    ?>
    <br>
    <a href="../../Admin/index.php" class="btn btn-secondary">Volver</a>
  </div>
</body>
</html>
