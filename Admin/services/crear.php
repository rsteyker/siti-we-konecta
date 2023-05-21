<!DOCTYPE html>
<html>
<head>
  <title>Crear producto</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Crear producto</h1>
    <form action="crear.php" method="POST">
      <div class="form-group">
        <label>Nombre:</label>
        <input type="text" class="form-control" name="nombre" required>
      </div>
      <div class="form-group">
        <label>Referencia:</label>
        <input type="text" class="form-control" name="referencia" required>
      </div>
      <div class="form-group">
        <label>Precio:</label>
        <input type="number" class="form-control" name="precio" required>
      </div>
      <div class="form-group">
        <label>Peso:</label>
        <input type="number" class="form-control" name="peso" required>
      </div>
      <div class="form-group">
        <label>Categoría:</label>
        <input type="text" class="form-control" name="categoria" required>
      </div>
      <div class="form-group">
        <label>Stock:</label>
        <input type="number" class="form-control" name="stock" required>
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="../../Admin/index.php" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>

  <?php
  // Importar la conexión de la bd
  require('../../config/database.php');

  // Procesamiento del formulario
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $referencia = $_POST['referencia'];
    $precio = $_POST['precio'];
    $peso = $_POST['peso'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $fechaCreacion = date('Y-m-d');


    // Insertar el nuevo producto
    $sql = "INSERT INTO productos (nombre_producto, referencia, precio, peso, categoria, stock, fecha_creacion)
            VALUES ('$nombre', '$referencia', $precio, $peso, '$categoria', $stock, '$fechaCreacion')";
    if ($conn->query($sql) === TRUE) {
      echo "<p>Producto creado correctamente.</p>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
  }
  ?>
</body>
</html>
