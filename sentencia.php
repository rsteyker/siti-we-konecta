<?php
    // Conexión a la base de datos
    require("config/database.php");

    // Consulta para conocer el producto con más stock
    $sqlProductoStock = "SELECT * FROM productos ORDER BY stock DESC LIMIT 1";
    $resultProductoStock = $conn->query($sqlProductoStock);

    if ($resultProductoStock->num_rows == 1) {
      $rowProductoStock = $resultProductoStock->fetch_assoc();
      $productoMasStock = $rowProductoStock['nombre'];
      echo "El producto con más stock es: " . $productoMasStock;
    } else {
      echo "No se encontraron productos.";
    }

    // Consulta para conocer el producto más vendido
    $sqlProductoMasVendido = "SELECT productos.nombre, SUM(ventas.cantidad) AS TotalVendido FROM productos INNER JOIN ventas ON productos.ID = ventas.ID_Producto GROUP BY productos.ID ORDER BY TotalVendido DESC LIMIT 1";
    $resultProductoMasVendido = $conn->query($sqlProductoMasVendido);

    if ($resultProductoMasVendido->num_rows == 1) {
      $rowProductoMasVendido = $resultProductoMasVendido->fetch_assoc();
      $productoMasVendido = $rowProductoMasVendido['nombre'];
      echo "El producto más vendido es: " . $productoMasVendido;
    } else {
      echo "No se encontraron productos vendidos.";
    }

    $conn->close();

?>




