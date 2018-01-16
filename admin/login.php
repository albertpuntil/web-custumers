<?php

function antiHack($pass)
{
	$pass = str_replace("%","",$pass);
	$pass = str_replace("' OR '1=1","",$pass);
	return $pass;
}

if (isset($_REQUEST["correu"])) $correu=$_REQUEST["correu"]; else $correu="";
if (isset($_REQUEST["password"])) $password=$_REQUEST["password"]; else $password="";
if ($correu!="" && $password!="") {
	include "../includes/connexio.php";
    obrirConnexioBD();
	$sql="SELECT count(*) AS n FROM usuaris WHERE correu='$correu' AND password='".antiHack($password)."'";
	$result = $conn->query($sql);
    if ($result->num_rows > 0) {
		session_start();
		$_SESSION["correu_usuari"]=$correu;
		header("Location:admin.php");
	}
}
?>

<?= '<'.'?xml version="1.0" encoding="UTF-8"'.'>'?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>Creació/edició de pagines</title>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8"/>
</head>
<body>
	<h3>Benvingut a l'eina d'administració</h3>
		<form name="form1" method="post" action="login.php">
			<table>
				<tr>
					<td>Correu electrònic:</td>
					<td><input type="text" name="correu" value="<?=$correu?>" maxlength="50" size="25"></td>
				</tr>
				<tr>
					<td>Mot de pas:</td>
					<td><input type="password" name="password" maxlength="15" size="25"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="submit" value="enviar"></td>
				</tr>
			</table>
		</form>
	</body>
</html>
