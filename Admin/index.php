<!DOCTYPE html>
<html>
<head>
  <title>Listado de productos</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Listado de productos</h1>
    <a href="./services/crear.php" class="btn btn-primary mb-3">Crear producto</a>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Referencia</th>
          <th>Precio</th>
          <th>Peso</th>
          <th>Categoría</th>
          <th>Stock</th>
          <th>Fecha de creación</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Importamos la base de datos
        require('../config/database.php');

        // Consulta de productos
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['nombre_producto']."</td>";
            echo "<td>".$row['referencia']."</td>";
            echo "<td>".$row['precio']."</td>";
            echo "<td>".$row['peso']."</td>";
            echo "<td>".$row['categoria']."</td>";
            echo "<td>".$row['stock']."</td>";
            echo "<td>".$row['fecha_creacion']."</td>";

            echo "<td><a href='services/editar.php?id=".$row['id']."' class='btn btn-primary btn-sm'>Editar</a> <a href='ventas/sale.php?id=".$row['id']."' class='btn btn-success btn-sm'>Vender</a> <a href='services/eliminar.php?id=".$row['id']."' class='btn btn-danger btn-sm'>Eliminar</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='9'>No hay productos registrados.</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
