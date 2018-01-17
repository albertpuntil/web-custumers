<?php
    include "includes/bootstrap.php";
    include "includes/connexio.php";
    $operacio="";
    if (isset($_REQUEST["operacio"])) $operacio=$_REQUEST["operacio"];
    if ($operacio!="new" && $operacio!="edit") header("Location: llistat_incidencies.php");
    $id_incidencia=$_REQUEST["id_incidencia"];
	$nom=$_REQUEST["nom"];
	$cognom1=$_REQUEST["cognom1"];
	$cognom2=$_REQUEST["cognom2"];
	$correu1=$_REQUEST["correu1"];
    $correu2=$_REQUEST["correu2"];
	$hora=$_REQUEST["hora"];
	$dia=$_REQUEST["dia"];
	$mes=$_REQUEST["mes"];
	$any=$_REQUEST["any"];
	$tecnic=$_REQUEST["tecnic"];
	$parroquia=$_REQUEST["parroquia"];
	$tipus=$_REQUEST["tipus"];
	$estat=$_REQUEST["estat"];
	$observacions=$_REQUEST["observacions"];
	$idioma=$_REQUEST["idioma"];
	$dificultat=$_REQUEST["dificultat"];
	$descripcio=$_REQUEST["descripcio"];
    if ($operacio=="new") {
        $sql="INSERT INTO incidencies (id_incidencia,nom,cognom1,cognom2,correu1,correu2,hora,dia,mes,any,tecnic,parroquia,tipus,estat,observacions,idioma,dificultat,descripcio) VALUES ($id_incidencia, \"$nom\", \"$cognom1\", \"$cognom2\", \"$correu1\", \"$correu2\", \"$hora\", $dia, $mes, $any, \"$tecnic\", \"$parroquia\", \"$tipus\", \"$estat\", \"$observacions\", \"$idioma\", \"$dificultat\", \"$descripcio\");";
    } else {
        $sql="UPDATE incidencies SET nom=\"$nom\",cognom1=\"$cognom1\",cognom2=\"$cognom2\",correu1=\"$correu1\",correu2=\"$correu2\",hora=\"$hora\",dia=$dia,mes=$mes,any=$any,tecnic=\"$tecnic\",parroquia=\"$parroquia\",tipus=\"$tipus\",estat=\"$estat\",observacions=\"$observacions\",idioma=\"$idioma\",dificultat=$dificultat,descripcio=\"$descripcio\" WHERE id_incidencia=$id_incidencia;";
    }
    obrirConnexioBD();
    if ($conn->query($sql) === TRUE) {
        tancarConnexioBD();
        header("Location: llistat_incidencies.php");
    } else { ?>
        <!DOCTYPE html>
        <html lang="en">
            <?php bsHead("Creat/modificat"); ?>
            <body>
                <div class="alert alert-danger" role="alert">
                    <h3>Error creant/modificant incidència</h3>
                    <p><?=$conn->error?></p>
                </div>
            </body>
        </html>
<?php
    }
    tancarConnexioBD();
?>
