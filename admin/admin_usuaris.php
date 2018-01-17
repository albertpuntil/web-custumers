<?php

include "includes/logat.php";

$pagina="admin_usuaris.php";

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
	$sql="SELECT id, nom, cognoms, passaport, correu FROM usuaris ORDER BY cognoms";
    $result = $conn->query($sql);
?>

        <?= '<'.'?xml version="1.0" encoding="UTF-8"'.'>'?>

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
                <head>
                        <title>Llistat d'usuaris</title>
                <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8"/>
        </head>
        <body>

<?php
    include "includes/menu.php";
	echo "<h3>Llistat d'usuaris</h3>
		<table width=\"80%\">
			<tr>
				<td><b>Nom</b></td>
				<td><b>Cognoms</b></td>
				<td><b>Passaport</b></td>
				<td><b>Correu electrònic</b></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>";
	while($row = $result->fetch_assoc()){
		$id=$row["id"];
		$nom=$row["nom"];
		$cognoms=$row["cognoms"];
		$passaport=$row["passaport"];
		$correu=$row["correu"];
		echo"<tr>
			<td>$nom</td>
			<td>$cognoms</td>
			<td>$passaport</td>
			<td>$correu</td>
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
			$cognoms="";
			$passaport="";
			$correu="";
			$password="";
        }
		if ($accio=="2") {
			$id=$_REQUEST["id"];
			include "../includes/connexio.php";
            obrirConnexioBD();
			$sql="SELECT nom, cognoms, passaport, correu, password FROM usuaris WHERE id=$id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
			$nom=$row["nom"];
			$cognoms=$row["cognoms"];
			$passaport=$row["passaport"];
			$correu=$row["correu"];
			$password=$row["passaport"];
			tancarConnexioBD();
		}
?>

        <?= '<'.'?xml version="1.0" encoding="UTF-8"'.'>'?>

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
                <head>
                        <title>Creació/edició d'usuaris</title>
                <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8"/>
        </head>
        <body>

<?php	include "includes/menu.php";
		echo "<h3>Creació/edició d'usuaris</h3>
			<form name=\"form1\" method=\"post\" action=\"$pagina?accio=3&id=$id\">
				<table>
					<tr>
						<td>Nom:</td>
						<td><input type=\"text\" name=\"nom\" value=\"$nom\" maxlength=\"100\"></td>
					</tr>
					<tr>
						<td>Cognoms:</td>
						<td><input type=\"text\" name=\"cognoms\" value=\"$cognoms\" maxlength=\"100\"></td>
					</tr>
					<tr>
						<td>Passaport:</td>
						<td><input type=\"text\" name=\"passaport\" value=\"$passaport\" maxlength=\"15\"></td>
					</tr>
					<tr>
						<td>Correu electrònic:</td>
						<td><input type=\"text\" name=\"correu\" value=\"$correu\" maxlength=\"50\"></td>
					</tr>
					<tr>
						<td>Mot clau:</td>
						<td><input type=\"password\" name=\"password\" value=\"$password\" maxlength=\"15\"></td>
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
	if (isset($_REQUEST["id"])) $id=$_REQUEST["id"]; else $id=0;
	$nom=$_REQUEST["nom"];
	$cognoms=$_REQUEST["cognoms"];
	$passaport=$_REQUEST["passaport"];
	$correu=$_REQUEST["correu"];
	$password=$_REQUEST["password"];
	include "../includes/connexio.php";
    obrirConnexioBD();
	if ($id==0) {
		$sql="INSERT INTO usuaris (nom, cognoms, passaport, correu, password) VALUES ('$nom', '$cognoms', '$passaport', '$correu', '$password')";
        $conn->query($sql);
	} else {
		$sql="UPDATE usuaris SET nom='$nom', cognoms='$cognoms', passaport='$passaport', correu='$correu', password='$password' WHERE id=$id";
        $conn->query($sql);
	}
	tancarConnexioBD();
	header("Location:$pagina");

// Esborrar
} elseif ($accio=="4") {
	$id=$_REQUEST["id"];
	include "../includes/connexio.php";
    obrirConnexioBD();
	$sql="DELETE FROM usuaris WHERE id=$id";
    $conn->query($sql);
	tancarConnexioBD();
	header("Location:$pagina");
}
?>
