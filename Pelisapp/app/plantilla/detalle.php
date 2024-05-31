<?php


$posterUrl = buscarPosterOMDB($peli->nombre);
$plotUrl = buscarPlotOMDB($peli->nombre);
$writertUrl = buscarWriterOMDB($peli->nombre);
$actorstUrl = buscarActorsOMDB($peli->nombre);
$yearUrl = buscarYearOMDB($peli->nombre);
$countryUrl = buscarCountryOMDB($peli->nombre);
$awardsUrl = buscarAwardsOMDB($peli->nombre);
$ratingsUrl = buscarRatingsOMDB($peli->nombre);
$metascoreUrl = buscarMetascoreOMDB($peli->nombre);
$imdbRatingUrl = buscarImdbRatingOMDB($peli->nombre);
$boxOfficeUrl = buscarBoxOfficeOMDB($peli->nombre);
$imdbIDUrl = buscarimdbIDOMDB($peli->nombre);




?>

<h2> Detalles </h2>

<table>
    <form name="Puntuacion" action="index.php" method="GET">
        <tr>
            <td>Puntuación </td>
            <td>
                <input type="hidden" name="codigo" value="<?= $peli->codigo_pelicula ?>">
                <input type="hidden" name="orden" value="Puntuacion">
                <input type="submit" name="Puntuacion" id="Puntuacion" value="1">
                <input type="submit" name="Puntuacion" id="Puntuacion" value="2">
                <input type="submit" name="Puntuacion" id="Puntuacion" value="3">
                <input type="submit" name="Puntuacion" id="Puntuacion" value="4">
                <input type="submit" name="Puntuacion" id="Puntuacion" value="5">
            </td>
        </tr>
    </form>



    <tr>
        <td>Valoración </td>
        <td> <?= $peli->puntuacion /  $peli->numero_puntuacion ?></td>
    </tr>
    <tr>
        <td>Numero de valoraciones </td>
        <td> <?= $peli->numero_puntuacion ?></td>
    </tr>
    <tr>
        <td>Código de película </td>
        <td> <?= $peli->codigo_pelicula ?></td>
    </tr>
    <tr>
        <td>Nombre </td>
        <td> <?= $peli->nombre ?></td>
    </tr>
    <td>Año </td>
    <td>
        <?php if ($yearUrl) : ?>

            <p><?= $yearUrl ?></p>
        <?php else : ?>
            <p></p>
        <?php endif; ?>
    </td>
    </tr>
    <tr>
        <td>Director </td>
        <td> <?= $peli->director ?></td>
    </tr>
    <tr>
        <td>Escritores </td>
        <td>
            <?php if ($writertUrl) : ?>

                <p><?= $writertUrl ?></p>
            <?php else : ?>
                <p></p>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>Reparto </td>
        <td>
            <?php if ($actorstUrl) : ?>

                <p><?= $actorstUrl ?></p>
            <?php else : ?>
                <p></p>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>Genero </td>
        <td> <?= $peli->genero ?></td>
    </tr>
    <tr>
        <td>País </td>
        <td>
            <?php if ($countryUrl) : ?>

                <p><?= $countryUrl ?></p>
            <?php else : ?>
                <p></p>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>Premios </td>
        <td>
            <?php if ($awardsUrl) : ?>

                <p><?= $awardsUrl ?></p>
            <?php else : ?>
                <p></p>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>Sinopsis </td>
        <td>
            <?php if ($plotUrl) : ?>

                <p><?= $plotUrl ?></p>
            <?php else : ?>
                <p></p>
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>Ratings </td>
        <td>
            <?php if ($ratingsUrl) : ?>

                <p>Rotten Tomatoes: <?= $ratingsUrl[1]['Value'] ?><br>
                <p>Metacritic: <?= $ratingsUrl[2]['Value'] ?><br>
                <p>Metascore: <?= $metascoreUrl ?><br>
                <p>imdbRating: <?= $imdbRatingUrl ?><br>
                <?php else : ?>
                <p></p>
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>Recaudación </td>
        <td>
            <?php if ($boxOfficeUrl) : ?>
                <p><?= $boxOfficeUrl ?></p>
            <?php else : ?>
                <p></p>
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>Imagen </td>
        <td>
            <img src="<?= 'app/img/' . $peli->imagen; ?>" width="230" height="300"></img>
        </td>
    </tr>
    <tr>
        <td>Poster </td>
        <td>
            <?php if ($posterUrl) : ?>

                <a href="https://www.imdb.com/title/<?= $imdbIDUrl ?>/">
                    <img src="<?= $posterUrl ?>" width="230" height="300">
                </a>

            <?php else : ?>
                <p>Poster no disponible.</p>
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>Trailer </td>
        <td>
            <?php if ($imdbIDUrl) : ?>
                <a href="https://www.imdb.com/title/<?= $imdbIDUrl ?>/">Trailer</a>

            <?php else : ?>
                <p></p>
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>Enlaces</td>
        <td>

            <div data-jw-widget data-api-key="ABCdef12" data-object-type="movie" data-title="<?= $peli->nombre ?>">
            </div>
            <div>
                <a data-original="https://www.justwatch.com" href="https://www.justwatch.com/us/movie/<?= $peli->nombre ?>">
                </a>
            </div>
            <script async src="https://widget.justwatch.com/justwatch_widget.js"></script>
        </td>
    </tr>
</table>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'">