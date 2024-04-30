<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formulario de Modificación</title>
</head>

<body>
  <h2>Modificar Película</h2>
  <form name="Modificacion" enctype="multipart/form-data" action="index.php?orden=Modificar&codigo=<?= $peli->codigo_pelicula ?>" method="POST">
    <label for="Titulo">Titulo:</label><br />
    <input type="text" id="Titulo" name="Titulo" value=<?= $peli->nombre ?> /><br /><br />

    <label for="Director">Director:</label><br />
    <input type="text" id="Director" name="Director" value=<?= $peli->director ?> /><br /><br />

    <label for="Genero">Genero:</label><br />
    <input type="text" id="Genero" name="Genero" value=<?= $peli->genero ?> /><br /><br />
    <label for="Imagen">Imagen:</label><br />
    <input type="file" id="imagen" name="imagen"> <br><br>
    <input type="submit" value="Modificar" />
    <button onclick="history.back()">Volver</button>
  </form>
</body>

</html>