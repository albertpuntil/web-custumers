<?php
    include "includes/bootstrap.php";
    include "includes/connexio.php";
    $operacio="";
    if (isset($_REQUEST["operacio"])) $operacio=$_REQUEST["operacio"];
    if ($operacio!="new" && $operacio!="edit") header("Location: llistat_incidencies.php");
    obrirConnexioBD();
    if ($operacio=="edit") {
        if (isset($_REQUEST["id_incidencia"])) {
            $id_incidencia=$_REQUEST["id_incidencia"];
            $sql = "SELECT * FROM incidencies WHERE id_incidencia=" . $id_incidencia;
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                tancarConnexioBD();
                header("Location: llistat_incidencies.php?");
            } else {
                $row = $result->fetch_assoc();
            }
        } else {
            header("Location: llistat_incidencies.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php bsHead("Llistat"); ?>
    <body>
	<div class="container">
		<h3><center><?php if ($operacio=="new") echo "Nova incidència"; else echo "Modificar incidència"; ?></center></h3>
        <br>
		<div class="row myform">
			<div class="col-md-7 col-md-offset-3">
                <div class="alert alert-info" role="alert">
				<form name="form_incidencies" action="mod_incidencia.php?operacio=<?=$operacio?>" role="form" method="post">
					<div class="form-group">
						<label class="control-label" for="id_incidencia">Número d'incidència:</label>
						<input required type="number" name="id_incidencia" id="id_incidencia" min="1" max="10000" class="form-control" placeholder="Introdueix el número d'incidència" value="<?=$row["id_incidencia"]?>"<?php if ($operacio=="edit") echo "readonly" ?>/>
					</div>
                    <div class="form-group">
						<label class="control-label" for="nom">Nom:</label>
						<input required type="text" name="nom" id="nom" maxlength="25" class="form-control" placeholder="Introdueix el nom" value="<?php if (isset($row)) echo $row["nom"]?>"/>
					</div>
					<div class="form-group">
						<label class="control-label" for="cognom1">Primer cognom:</label>
						<input required type="text" name="cognom1" id="cognom1" maxlength="25" class="form-control" placeholder="Introdueix el primer cognom" value="<?php if (isset($row)) echo $row["cognom1"]?>"/>
					</div>
					<div class="form-group">
						<label class="control-label" for="cognom2">Segon cognom:</label>
						<input required type="text" name="cognom2" id="cognom2" maxlength="25" class="form-control" placeholder="Introdueix el segon cognom" value="<?php if (isset($row)) echo $row["cognom2"]?>"/>
					</div>
                    <br>
					<div class="form-inline">
						<div class="form-group">
							<label class="control-label" for="correu1">Correu electrònic:</label>
							<input required type="text" name="correu1" id="correu1" maxlength="50" class="form-control" placeholder="Introdueix el correu" value="<?php if (isset($row)) echo $row["correu1"]?>"/>
						</div>
						<div class="form-group">
							<label class="control-label" for="correu2">@</label>
							<input required type="text" name="correu2" id="correu2" maxlength="50" class="form-control" placeholder="Introdueix el domini" value="<?php if (isset($row)) echo $row["correu2"]?>"/>
						</div>
					</div>
                    <br>
					<div class="form-inline">
                        <div class="form-group">
                                <label class="control-label" for="hora">Hora:</label>
                                <input required type="time" name="hora" id="hora" class="form-control" placeholder="Introdueix l'hora" value="<?php if (isset($row)) echo $row["hora"]?>"/>
                        </div>
                    </div>
                    <br>
					<div class="form-inline">
						<div class="form-group">
							<label class="control-label" for="dia">Dia:</label>
							<input required type="number" name="dia" id="dia" min="1" max="31" class="form-control" placeholder="Dia" value="<?php if (isset($row)) echo $row["dia"]?>"/>
						</div>
						<div class="form-group">
							<label class="control-label" for="mes">Mes:</label>
							<input required type="number" name="mes" id="mes" min="1" max="12" class="form-control" placeholder="Mes" value="<?php if (isset($row)) echo $row["mes"]?>"/>
						</div>
						<div class="form-group">
							<label class="control-label" for="any">Any:</label>
							<input required type="number" name="any" id="any" min="2015" max="2050" class="form-control" placeholder="Any" value="<?php if (isset($row)) echo $row["any"]?>"/>
						</div>
					</div>
                    <br>
                    <div class="form-group">
					   <label class="control-label" for="tecnic">Tècnic que atén la incidència:</label>
                        <select class="form-control" name="tecnic" id="tecnic">
				            <option value="0325"<?php if (isset($row)) if ($row["tecnic"]=="0325") echo " selected";?>>Joan Martínez</option>
                            <option value="0330"<?php if (isset($row)) if ($row["tecnic"]=="0330") echo " selected";?>>Marta Puig</option>
                            <option value="0335"<?php if (isset($row)) if ($row["tecnic"]=="0335") echo " selected";?>>David Peret</option>
                            <option value="0340"<?php if (isset($row)) if ($row["tecnic"]=="0340") echo " selected";?>>Josep Roig</option>
                            <option value="0345"<?php if (isset($row)) if ($row["tecnic"]=="0345") echo " selected";?>>Dora Iscla</option>
					   </select>
					</div>
                    <div class="form-group">
                        <label class="control-label" for="parroquia">Parròquia:</label>
                <?php   $sql = "SELECT * FROM parroquies ORDER BY id_parroquia;";
                        $resultSelect = $conn->query($sql);
                        while($rowSelect = $resultSelect->fetch_assoc()) { ?>
                            <div class="radio">
                               <label>
                                    <input type="radio" name="parroquia" id="parroquia" value="<?=$rowSelect["id_parroquia"]?>"<?php if (isset($row)) if ($row["parroquia"]==$rowSelect["id_parroquia"]) echo " checked";?>>
                                    <?=$rowSelect["nom_parroquia"]?>
                               </label>
                            </div>
                <?php   } ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="tipus">Tipus incidència:</label>
                        <select class="form-control" name="tipus" id="incidencia">
                            <option value="hardware"<?php if (isset($row)) if ($row["tipus"]=="hardware") echo " selected";?>>Hardware</option>
                            <option value="software"<?php if (isset($row)) if ($row["tipus"]=="software") echo " selected";?>>Software</option>
                            <option value="ofimàtica"<?php if (isset($row)) if ($row["tipus"]=="ofimàtica") echo " selected";?>>Ofimàtica</option>
                            <option value="navegació"<?php if (isset($row)) if ($row["tipus"]=="navegació") echo " selected";?>>Navegació</option>
                            <option value="missatgeria"<?php if (isset($row)) if ($row["tipus"]=="missatgeria") echo " selected";?>>Missatgeria</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="estat">Solucionada:</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="estat" id="estat" value="solucionada"<?php if (isset($row)) if ($row["estat"]=="solucionada") echo " checked";?>>
                                Solucionada
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="estat" id="estat" value="pendent"<?php if (isset($row)) if ($row["estat"]=="pendent") echo " checked";?>>
                                Pendent de revisió
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="estat" id="estat" value="enviat"<?php if (isset($row)) if ($row["estat"]=="enviat") echo " checked";?>>
                                S'envia un tècnic
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
					   <label class="control-label" for="observacions">Observacions:</label>
						<div class="checkbox" name="observacions">
					       <label><input type="checkbox" name="observacions" id="observacions" value="primera"<?php if (isset($row)) if ($row["observacions"]=="primera") echo " checked";?>>Primera incidènica</label>
						</div>
                        <div class="checkbox">
					       <label><input type="checkbox" name="observacions" id="observacions" value="satisfet"<?php if (isset($row)) if ($row["observacions"]=="satisfet") echo " checked";?>>Client satisfet</label>
						</div>
                        <div class="checkbox">
					       <label><input type="checkbox" name="observacions" id="observacions" value="no usual"<?php if (isset($row)) if ($row["observacions"]=="no usual") echo " checked";?>>Incidencia poc usual</label>
						</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="idioma">Idioma:</label>
                        <select class="form-control" name="idioma" id="idioma">
                            <option value="ca"<?php if (isset($row)) if ($row["idioma"]=="ca") echo " selected";?>>Català</option>
                            <option value="es"<?php if (isset($row)) if ($row["idioma"]=="es") echo " selected";?>>Castellà</option>
                            <option value="fr"<?php if (isset($row)) if ($row["idioma"]=="fr") echo " selected";?>>Francès</option>
                            <option value="pt"<?php if (isset($row)) if ($row["idioma"]=="pt") echo " selected";?>>Portuguès</option>
                            <option value="en"<?php if (isset($row)) if ($row["idioma"]=="en") echo " selected";?>>Anglès</option>
                            <option value="other"<?php if (isset($row)) if ($row["idioma"]=="other") echo " selected";?>>Altres</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="dificultat">Grau de dificultat:</label>
                        <select class="form-control" name="dificultat" id="dificultat">
                            <option value="1"<?php if (isset($row)) if ($row["dificultat"]==1) echo " selected";?>>1</option>
                            <option value="2"<?php if (isset($row)) if ($row["dificultat"]==2) echo " selected";?>>2</option>
                            <option value="3"<?php if (isset($row)) if ($row["dificultat"]==3) echo " selected";?>>3</option>
                            <option value="4"<?php if (isset($row)) if ($row["dificultat"]==4) echo " selected";?>>4</option>
                            <option value="5"<?php if (isset($row)) if ($row["dificultat"]==5) echo " selected";?>>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="descripcio">Descripció incidència:</label>
                        <textarea class="form-control" rows="5" name="descripcio" id="descripcio"><?php if (isset($row)) echo $row["descripcio"];?></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <center>
                            <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-send"></span> Enviar</button>
                            <button type="button" onClick="window.print();" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> imprimir</button>
                        </center>
                    </div>
				</form>
			</div>
            </div>
    	</div>
	</div>
    <?php tancarConnexioBD(); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
