<h2> Detalles </h2>
<table>
    <tr>
        <td>Codigo </td>
        <td> <?= $peli->codigo_pelicula ?></td>
    </tr>
    <tr>
        <td>Titulo </td>
        <td> <?= $peli->nombre ?></td>
    </tr>

    <tr>
        <td>Director </td>
        <td> <?= $peli->director ?></td>
    </tr>

    <tr>
        <td>Genero </td>
        <td> <?= $peli->genero ?></td>
    </tr>

    <tr>
        <td>Imagen: </td>
        <td> <img src="<?= 'app/img/' . $peli->imagen ?>" </td>
    </tr>

</table><br>
<button onclick="history.back()">Volver</button>