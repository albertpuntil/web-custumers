<?php

include "includes/logat.php";

$pagina="admin_parroquies.php";

// Accions de manteniment d'usuaris
//	0 -> Llistar
//	1 -> Nou
//	2 -> Editar
//	3 -> Recollir usuari des de 1 i 2
//	4 -> Esborrar

if (isset($_REQUEST["accio"])) $accio=$_REQUEST["accio"]; else $accio="0";

// Llistar
if ($accio=="0") {
	include "../includes/connexio.php";
    obrirConnexioBD();
	$sql="SELECT id_parroquia id, nom_parroquia nom FROM parroquies ORDER BY nom_parroquia";
    $result = $conn->query($sql);
?>

        <?= '<'.'?xml version="1.0" encoding="UTF-8"'.'>'?>

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
                <head>
                        <title>Llistat de parroquies</title>
                <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8"/>
        </head>
        <body>

<?php
    include "includes/menu.php";
	echo "<h3>Llistat de parròquies</h3>
		<table width=\"80%\">
			<tr>
				<td><b>Id</b></td>
				<td><b>Nom</b></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>";
	while($row = $result->fetch_assoc()){
		$id=$row["id"];
		$nom=$row["nom"];
		echo"<tr>
			<td>$id</td>
			<td>$nom</td>
			<td><a href=\"$pagina?accio=2&id=$id\">editar</a></td>
			<td><a href=\"$pagina?accio=4&id=$id\">esborrar</a></td>
		</tr>";
	}
	tancarConnexioBD();
	echo "<tr><td colspan=\"5\"><a href=\"$pagina?accio=1&id=0\">nou</a></td></tr>
	</table>
	</body>
	</html>";

// Nou o editar
} elseif ($accio=="1" || $accio=="2"){
        if ($accio=="1") {
            $id="";
            $nom="";
        }
		if ($accio=="2") {
			$id=$_REQUEST["id"];
			include "../includes/connexio.php";
            obrirConnexioBD();
			$sql="SELECT nom_parroquia nom FROM parroquies WHERE id_parroquia='$id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
			$nom=$row["nom"];
			tancarConnexioBD();
		}
?>

        <?= '<'.'?xml version="1.0" encoding="UTF-8"'.'>'?>

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
                <head>
                        <title>Creació/edició de parròquies</title>
                <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8"/>
        </head>
        <body>

<?php	include "includes/menu.php";
		echo "<h3>Creació/edició de parròquies</h3>
			<form name=\"form1\" method=\"post\" action=\"$pagina?accio=3&id=$id\">";
        if ($accio=="2") echo "<input type=\"hidden\" name=\"id_old\" value=\"$id\">";
        echo "  <table>
					<tr>
						<td>Id:</td>
						<td><input type=\"text\" name=\"id\" value=\"$id\" maxlength=\"5\"></td>
					</tr>
					<tr>
						<td>Nom:</td>
						<td><input type=\"text\" name=\"nom\" value=\"$nom\" maxlength=\"100\"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type=\"submit\" name=\"submit\" value=\"enviar\"></td>
					</tr>
				</table>
			</form>
		</body>
	</html>";

// Recollir dades
} elseif ($accio=="3") {
	if (isset($_REQUEST["id_old"])) $id_old=$_REQUEST["id_old"]; else $id_old="";
	$id=$_REQUEST["id"];
	$nom=$_REQUEST["nom"];
	include "../includes/connexio.php";
    obrirConnexioBD();
	if ($id_old=="") {
		$sql="INSERT INTO parroquies (id_parroquia, nom_parroquia) VALUES ('$id', '$nom')";
        $conn->query($sql);
	} else {
		$sql="UPDATE parroquies SET id_parroquia='$id', nom_parroquia='$nom' WHERE id_parroquia='$id_old'";
        $conn->query($sql);
	}
	tancarConnexioBD();
	header("Location:$pagina");

// Esborrar
} elseif ($accio=="4") {
	$id=$_REQUEST["id"];
	include "../includes/connexio.php";
    obrirConnexioBD();
	$sql="DELETE FROM parroquies WHERE id_parroquia='$id'";
    $conn->query($sql);
	tancarConnexioBD();
	header("Location:$pagina");
}
?>
