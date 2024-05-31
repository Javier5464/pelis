<?php
include_once 'app/Pelicula.php';

$ruta = $_SERVER['PHP_SELF'];



?>
<?php if (isset($_SESSION["usuario"])) : ?>
	<form action="index.php" method="GET">
		<input type='submit' name='orden' value='Logout'>

	</form>
<?php else : ?>
	<form action="index.php" method="GET">
		<input type='submit' name='orden' value='Login'>

	</form>
<?php endif; ?>

<form action="index.php" method="GET">
	<input type="text" name="valor" placeholder="Buscar">&#128270
	<th>
		<input type='submit' name='orden' value='Buscar Título'>
		<input type='submit' name='orden' value='Buscar Director'>
		<input type='submit' name='orden' value='Buscar Genero'>
</form><br>
<form action='index.php'>
	<input type='hidden' name='orden' value='VerPelis'>
	<input type='submit' value='Ver Todos'>
	Tenemos <?= count($peliculas) ?> películas seleccinadas de nuestro catalogo.
</form>
<table>
	<tr>
		<th>Código</th>
		<th>Nombre</th>
		<th>Director</th>
		<th>Género</th>
		<th>Acciones</th>
	</tr>
	<?php foreach ($peliculas as $peli) : ?>
		<tr>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
			<td><?= $peli->codigo_pelicula ?></td>
			<td><?= $peli->nombre ?></td>
			<td><?= $peli->director ?></td>
			<td><?= $peli->genero ?></td>

			<td>
				<?php if (isset($_SESSION["usuario"])) : ?>
					<a href="#" onclick="confirmarBorrar('<?php echo $peli->nombre . "','" . $peli->codigo_pelicula; ?>');"><i class="fas fa-trash-alt"></i></a>
					<a href="<?= $ruta ?>?orden=Modificar&codigo=<?= $peli->codigo_pelicula ?>"><i class="fas fa-edit"></i></a>
				<?php endif; ?>
				<a href="<?= $ruta ?>?orden=Detalles&codigo=<?= $peli->codigo_pelicula ?>"><i class="fas fa-info-circle"></i></a>
			</td>

		</tr>
	<?php endforeach; ?>
</table>
<br>

<form name='f2' action='index.php?orden=Alta'>
	<button type='submit' name="orden" value='Alta'><i class="fas fa-plus-circle"></i> </button>
</form>
<br>

<form name='f3' action='index.php?orden=DescargarJSON'>
	<button name='orden' name="orden" value='DescargarJSON'> Descargar peliculas </button>
</form>