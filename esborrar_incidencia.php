<?php
    $id_incidencia=$_REQUEST["id_incidencia"];
    include "includes/bootstrap.php";
    include "includes/connexio.php";
    $sql="DELETE FROM incidencies WHERE id_incidencia=".$id_incidencia;
    obrirConnexioBD();
    if ($conn->query($sql) === TRUE) {
        tancarConnexioBD();
        header("Location: llistat_incidencies.php");
    } else { ?>
        <!DOCTYPE html>
        <html lang="en">
            <?php bsHead("Esborrat"); ?>
            <body>
                <div class="alert alert-danger" role="alert">
                    <h3>Error esborrant incidència</h3>
                    <p><?=$conn->error?></p>
                </div>
            </body>
        </html>
<?php
    }
    tancarConnexioBD();
?>
