<!DOCTYPE html>
<html>
<head>
  <title>Editar producto</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Editar producto</h1>
    <?php
    // Verificar si se ha proporcionado un ID válido
    if (isset($_GET['id'])) {
      $id = $_GET['id'];

      // Conexión a la base de datos
      require("../../config/database.php");

      // Consultar el producto por ID
      $sql = "SELECT * FROM productos WHERE ID = $id";
      $result = $conn->query($sql);

      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>
        <form action="editar.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
          <div class="form-group">
            <label>Nombre:</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo $row['nombre_producto']; ?>" required>
          </div>
          <div class="form-group">
            <label>Referencia:</label>
            <input type="text" class="form-control" name="referencia" value="<?php echo $row['referencia']; ?>" required>
          </div>
          <div class="form-group">
            <label>Precio:</label>
            <input type="number" class="form-control" name="precio" value="<?php echo $row['precio']; ?>" required>
          </div>
          <div class="form-group">
            <label>Peso:</label>
            <input type="number" class="form-control" name="peso" value="<?php echo $row['peso']; ?>" required>
          </div>
          <div class="form-group">
            <label>Categoría:</label>
            <input type="text" class="form-control" name="categoria" value="<?php echo $row['categoria']; ?>" required>
          </div>
          <div class="form-group">
            <label>Stock:</label>
            <input type="number" class="form-control" name="stock" value="<?php echo $row['stock']; ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
          <a href="../../Admin/index.php" class="btn btn-secondary">Cancelar</a>
        </form>
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
    $nombre = $_POST['nombre'];
    $referencia = $_POST['referencia'];
    $precio = $_POST['precio'];
    $peso = $_POST['peso'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];

    // Conexión a la base de datos
    require("../../config/database.php");

    // Actualizar el producto
    $sql = "UPDATE productos SET nombre_producto='$nombre', referencia='$referencia', precio=$precio, peso=$peso, categoria='$categoria', stock=$stock WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
      echo "<p>Producto actualizado correctamente.</p>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
  }
  ?>
</body>
</html>
