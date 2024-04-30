<?php
include_once 'app/Pelicula.php';

$ruta = $_SERVER['PHP_SELF'];

?>
<form name='fBuscar' action='index.php?orden=Buscar'>
	<input type="text" id="a" name="a">
	<button type='submit' name="orden" value='Titulo'><i class="fas fa-search"></i> Buscar por Título</button>
	<button type='submit' name="orden" value='Director'><i class="fas fa-search"></i> Buscar por Director</button>
	<button type='submit' name="orden" value='Genero'><i class="fas fa-search"></i> Buscar por Género</button>
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
				<a href="#" onclick="confirmarBorrar('<?php echo $peli->nombre . "','" . $peli->codigo_pelicula; ?>');"><i class="fas fa-trash-alt"></i></a>
				<a href="<?= $ruta ?>?orden=Modificar&codigo=<?= $peli->codigo_pelicula ?>"><i class="fas fa-edit"></i></a>
				<a href="<?= $ruta ?>?orden=Detalles&codigo=<?= $peli->codigo_pelicula ?>"><i class="fas fa-info-circle"></i></a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
<br>
<form name='f2' action='index.php?orden=Alta'>
	<button type='submit' name="orden" value='Alta'><i class="fas fa-plus-circle"></i> </button>
</form>