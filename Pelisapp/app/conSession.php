<?php
session_start();
if (!isset($_SESSION['contador'])) {
    $_SESSION['contador'] = 0;
}
$contador = $_SESSION['contador'];
if (isset($_GET["orden"])) {
    switch ($_GET["orden"]) {
        case 'suma':
            $contador++;
            verFormulario($contador);
            break;
        case 'resta':
            $contador--;
            verFormulario($contador);
            break;
        case 'anular':
            session_destroy();
            verRecargar();
            break;
    }
}

function verFormulario($contador)
{
    ?>
    <html>
    <h1>Contador session</h1>
    Valor contador: <?= $contador ?>
    <form method="get">
        <button name="orden" value="suma">Incrementar</button>
        <button name="orden" value="resta">Decrementar</button>
        <button name="orden" value="anular">Anular</button>
    </form>
    </html>
    <?php
}

function verRecargar()
{
    ?>
    <html>
    <h1>Contador session</h1>
    La sesión ha sido anulada
    <input type="button" value="Recargar" onclick="location.reload()"/>
    </html>
    <?php
}
?>
