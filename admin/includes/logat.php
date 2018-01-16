<?php
    session_start();
	if ($_SESSION["correu_usuari"]=="") {
		header("Location:login.php");
	} ?>
