<?php
/**
 * Muestra las posibles tablas con las que formar un mapa
 * IMPORTANTE: Para el caso de ser una tabla con 2 variables, indicarlo en el checkbox
 * Una vez que se pulsa "enviar", se ejecuta buildMap.php
 */

//Variables de conexion
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "ecotrab";
$dbname = "visualizacion";



$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());

mysql_select_db($dbname) or die("Error al conectar a la base de datos.");
//MOSTRAMOS TODAS LAS TABLAS
$Sql ="SHOW TABLES";
$result = mysql_query( $Sql ) or die("No se puede ejecutar la consulta: ".mysql_error());
$contador = 0;

echo('<FORM METHOD="post" ACTION="buildMap.php">');
echo('<select size="1" name="tema">');

// Recorremos las tablas
while($Rs = mysql_fetch_array($result)) {
	// No mostramos la table de caracterisitcas ni las de Intervalos
	if($Rs[0] != "Medidas" && substr($Rs[0], 0, 10) != "Intervalos"){
		$contador++;
		echo('<option value="');
		echo($Rs[0]);
		echo('">');
		echo($Rs[0]);
		echo('</option>');
		echo($contador);
	}
}
echo('</select>');
echo('<input type="checkbox" name="option1" value="2Variables"> 2 variables<br>');

echo('<p><input type="submit" value="Ver mapa" name="enviar"> ');
echo('</FORM>');

?>