<?php
/**
 * Realiza la subida de los ficheros indicados al servidor y crea las respectivas tablas en la base de datos: tabla de datos y tabla de intervalos.
 * IMPORTANTE: Para el caso de dos variables, debe indicarse en el checkbox
 * En el caso de ficheros de intervalos, los campos deben llamarse: 
 * min_t	p20_t	p40_t	p60_t	p80_t	max_t; en el caso de dos variables:
		min_t2	p20_t2	p40_t2	p60_t2	p80_t2	max_t2
	
	SI NO SE LLAMAN ASI NO DA ERROR, PERO DARA ERROR AL VISUALIZAR EL MAPA
 * 
 */

// Variables de conexion
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "ecotrab";
$dbname = "visualizacion";

// Directorio donde se almacenaran los ficheros
$target_path = "uploads/";

// Obtenemos la ruta que tendra el fichero
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
// Realizamos la subida del fichero
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
	echo "El fichero".  basename( $_FILES['uploadedfile']['name']).
    " ha sido subido al servidor correctamente";

	// Conexion a la base de datos
	$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Error al conectar a la base de datos: " . mysql_error());
	// Seleccion de base de datos
	mysql_select_db($dbname) or die("Error al seleccionar la base de datos.");

	$file = file($target_path);
	$baseName = basename( $_FILES['uploadedfile']['name']);

	$nameFile = substr($baseName, 0, count($baseName)-5);
	// Crea la tabla principal del tema en la base de datos, para ello, leemos el fichero linea por linea, 
	foreach($file as $n=>$linea) {
		/* Si es la primera linea, se ejecuta la sentencia de creacion de tabla con los campos indicados en el fichero*/
		if($n == 0){
			// Si la tabla ya existe, la borramos para sobreescribirla
			mysql_query("DROP TABLE IF EXISTS ".$nameFile.";") or die("ERROR AL SOBRESCRIBIR TABLA: ".$nameFile);
			$splt = split("\t", $linea);
			$sql = " CREATE TABLE ".$nameFile." (";
			for($i = 0; $i < count($splt); $i++){
				if($i == count($splt) - 1){
					$sql = $sql.$splt[$i]." double NOT NULL ";
				}
				else{
					if($_POST["option1"] === "2Variables" && $i == count($splt) -2){
						$sql = $sql.$splt[$i]." double NOT NULL, ";
					}
					else{
						$sql = $sql.$splt[$i]." int NOT NULL, ";	
					}
				}
			}
			$sql = $sql . ") TYPE=MyISAM;";
			mysql_query($sql);
		}
		// Si no es la primera linea, realizamos los inserts correspondientes.
		else{
			$splt = split("\t", $linea);
			$cadena = "";
			for($i = 0; $i < count($splt); $i++){
				if($i == count($splt) - 1){
					$cadena = $cadena.$splt[$i] ;

				}
				else{
					$cadena = $cadena.$splt[$i] ." , ";

				}

			}
			$sql = "INSERT INTO ".$nameFile." VALUES (".$cadena.");";
			mysql_query($sql) or die("ERROR AL INSERTAR DATOS EN LA BD");
		}
	}
	// TABLA DE INTERVALOS
	$target_path = "uploads/".basename( $_FILES['uploadedfileInterval']['name']);
	if(move_uploaded_file($_FILES['uploadedfileInterval']['tmp_name'], $target_path)) {
		echo "El fichero ".  basename( $_FILES['uploadedfileInterval']['name']).
    " ha sido subido al servidor correctamente";
		$file = file($target_path);
		$baseName = basename( $_FILES['uploadedfileInterval']['name']);
		$nameFile = "Intervalos".$nameFile;
		// Crea la tabla principal de Intervalos del tema en la base de datos
		foreach($file as $n=>$linea) {
			// Si es la primera linea, creamos la tabla.
			if($n == 0){
				// Borramos la tabla para poder sobreescribirla.
				mysql_query("DROP TABLE IF EXISTS ".$nameFile.";") or die("ERROR AL SOBRESCRIBIR TABLA: ".$nameFile);
				$splt = split("\t", $linea);
				$sql = "CREATE TABLE ".$nameFile." (";
				for($i = 0; $i < count($splt); $i++){
					if($i == count($splt) - 1){
						$sql = $sql.$splt[$i]." int NOT NULL ";
					}
					else{
						$sql = $sql.$splt[$i]." int NOT NULL, ";
					}
				}
				$sql = $sql . ") TYPE=MyISAM;";
				mysql_query($sql);
			}
			// Si no es la primera linea, insertamos los datos en la base de datos.
			else{
				$splt = split("\t", $linea);
				$cadena = "";
				for($i = 0; $i < count($splt); $i++){
					if($i == count($splt) - 1){
						$cadena = $cadena.$splt[$i] ;
					}
					else{
						$cadena = $cadena.$splt[$i] ." , ";
					}
				}
				$sql = "INSERT INTO ".$nameFile." VALUES (".$cadena.");";
				mysql_query($sql);
			}
		}
	}
	else{
		echo("Error al subir el fichero de intervalos");

	}

} else{
	echo "There was an error uploading the file, please try again!";
}

?>