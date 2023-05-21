<!DOCTYPE html>
<html>
<head>
  <title>Eliminar producto</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Eliminar producto</h1>
    <?php
    // Verificar si se ha proporcionado un ID válido
    if (isset($_GET['id'])) {
      $id = $_GET['id'];

      // Conexión a la base de datos
      require("../../config/database.php");

      // Consultar el producto por ID
      $sql = "SELECT * FROM productos WHERE id = $id";
      $result = $conn->query($sql);

      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['nombre_producto']; ?></h5>
            <p class="card-text">Referencia: <?php echo $row['referencia']; ?></p>
            <p class="card-text">Precio: <?php echo $row['precio']; ?></p>
            <p class="card-text">Peso: <?php echo $row['peso']; ?></p>
            <p class="card-text">Categoría: <?php echo $row['categoria']; ?></p>
            <p class="card-text">Stock: <?php echo $row['stock']; ?></p>
            <form action="eliminar.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <button type="submit" class="btn btn-danger">Eliminar</button>
              <a href="../../Admin/index.php" class="btn btn-secondary">Cancelar</a>
            </form>
          </div>
        </div>
        <?php
      } else {
        echo "<p>No se encontró el producto.</p>";
      }
      $conn->close();
    } else {
      echo "<p>Debe proporcionar un ID de producto válido.</p>";
    }
    ?>
  </div>
  <?php
  // Procesamiento del formulario
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Conexión a la base de datos
    require("../../config/database.php");

    // Eliminar el producto por ID
    $sql = "DELETE FROM productos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
      echo "<p>Producto eliminado correctamente.</p>";
    } else {
      echo "Error al eliminar el producto: " . $conn->error;
    }
    $conn->close();
  }
  ?>
</body>
</html>
