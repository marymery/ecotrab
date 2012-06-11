<?php

/**
 * Genera el mapa completo. Para ello:
 * 1. Genera los ficheros JSON de los que se alimentara el mapa
 * 1.1. Genera un fichero por cada años
 * 1.2. Cada fichero contiene una tupla por cada instancia posible del conjunto de caracteristicas
 * 1.3 Crea los ficheros JSON de intervalos
 * 2. Genera el codigo JavaScript que contiene el mapa.
 * 2.1. Crea el mapa con el estado inicial 99 (todos) en todas las caracteristicas
 * 2.2. Crea los distintos botones select para cambiar las caracteristicas. Para ello, la interpretación de cada variable/caracteristica esta en la tabla Medidas
 * 
 */

// Variables de conexion
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "ecotrab";
$dbname = "visualizacion";

// Si tiene valor es que se ha pulsado, si no es ""
echo($_POST["option1"]);

// Conexion a la base de datos
$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());
// Seleccion de base de datos
mysql_select_db($dbname) or die("Error al conectar a la base de datos.");

// Consultamos los campos que tiene la tabla
$Sql2 ="DESCRIBE ".$_POST['tema'];
$result2 = mysql_query( $Sql2 ) or die("No se puede ejecutar la consulta: ".mysql_error());

// Array que contiene el nombre de los campos de la tabla
$arrayCampos = array();

$i = 0;
while($Rs2 = mysql_fetch_array($result2)) {
	// Insertamos cada campo en un array
	$arrayCampos[$i] = $Rs2["Field"];
	$i++;
}
// Cadena que se utilizara para indicar las consultas al fichero JSON
$cadenaConsultaJSON = "";

// Cadena que va antes del where, contiene las caracteristicas
$cadena1 = "";
$i = 0;
for($i = 2; $i < count($arrayCampos) -1; $i++){
	if($i == 2){
		$cadena1 = $arrayCampos[$i];
	}
	else{
		$cadena1 = $cadena1.", ".$arrayCampos[$i];
	}
}
// Cadena que va despues del where, contiene los valores de las caracteristicas
$cadena2 = "";
// Obtenemos los anyos disponibles
$sql = "SELECT year FROM ".$_POST["tema"]." GROUP BY year;";
$sql_ejecutar = mysql_query($sql) or die ("Error".$sql."<br>".mysql_error()."<br>");
$contador = 0;
$yearInicial = 0;
while($fila = mysql_fetch_assoc($sql_ejecutar)){
	if($contador == 0){
		$yearInicial = (int)$fila[year];
		$contador++;
	}
	else{
		$yearFinal++;
	}
}
$yearFinal = (int)$yearInicial + $yearFinal;

$sql = "SELECT year, prov_resid,".$arrayCampos[count($arrayCampos)-1].",".$cadena1." FROM ".$_POST["tema"]." GROUP BY year, prov_resid, ".$cadena1.";";
$sql_ejecutar = mysql_query($sql) or die ("Error".$sql."<br>".mysql_error()."<br>");
//echo($sql);
$sql_return = mysql_num_rows($sql_ejecutar);
/*Ahora miramos si sql nos da por lo menos una linea de respuesta*/
if ($sql_return > 0){
	$descriptores = array();
	$contador = $yearInicial;
	// Creamos un fichero JSON por cada anyo
	while($yearFinal >= $contador){
		$descriptores[$contador] = fopen("/var/www/ecotrab_ecotrab/ProyectoVisualizacion/dojo-release-1.7.2-src/dojox/geo/charting/tests/datastore/fichero".$contador.".json", w);
		fputs($descriptores[$contador], "{	\"identifier\": \"Provincia\",	\"label\": \"Provincia\",	\"items\": [");

		$contador++;

	}
	/************************INICIO CREACION FICHEROS JSON DATOS ***********************/
	$bool = false;
	$yearActual = "";
	$provinciaActual = "";
	$contador = 0;
	$array = array();
	while($fila = mysql_fetch_assoc($sql_ejecutar)){
		$boolTodo = "0";
		$cadenaConsultaJSON = "";
		if($_POST["option1"] === "2Variables"){
			for($i = 2; $i < count($arrayCampos) -2; $i++){
				// Obtenemos la consulta JSON
				$cadenaConsultaJSON = $cadenaConsultaJSON.$arrayCampos[$i]."-".$fila[$arrayCampos[$i]]."-";
			}
		}
		else{
			for($i = 2; $i < count($arrayCampos) -1; $i++){
				// Obtenemos la consulta JSON
				$cadenaConsultaJSON = $cadenaConsultaJSON.$arrayCampos[$i]."-".$fila[$arrayCampos[$i]]."-";
			}
		}
		$array[$contador] = $cadenaConsultaJSON;
		$contador++;

		$descFile = $descriptores[$fila["year"]];
		/* Obtenemos la provincia */
		$provincia = "";
		if($fila["prov_resid"] == 1){
			$provincia = "Álava";
		}
		if($fila["prov_resid"] == 2){
			$provincia = "Albacete";
		}
		if($fila["prov_resid"] == 3){
			$provincia = "Alicante";
		}
		if($fila["prov_resid"] == 4){
			$provincia = "Almería";
		}
		if($fila["prov_resid"] == 5){
			$provincia = "Ávila";
		}
		if($fila["prov_resid"] == 6){
			$provincia = "Badajoz";
		}
		if($fila["prov_resid"] == 7){
			$provincia = "Baleares";
		}
		if($fila["prov_resid"] == 8){
			$provincia = "Barcelona";
		}
		if($fila["prov_resid"] == 9){
			$provincia = "Burgos";
		}
		if($fila["prov_resid"] == 10){
			$provincia = "Cáceres";
		}
		if($fila["prov_resid"] == 11){
			$provincia = "Cádiz";
		}
		if($fila["prov_resid"] == 12){
			$provincia = "Castellón";
		}
		if($fila["prov_resid"] == 13){
			$provincia = "Ciudad Real";
		}
		if($fila["prov_resid"] == 14){
			$provincia = "Córdoba";
		}
		if($fila["prov_resid"] == 15){
			$provincia = "A Coruña";
		}
		if($fila["prov_resid"] == 16){
			$provincia = "Cuenca";
		}
		if($fila["prov_resid"] == 17){
			$provincia = "Girona";
		}
		if($fila["prov_resid"] == 18){
			$provincia = "Granada";
		}
		if($fila["prov_resid"] == 19){
			$provincia = "Guadalajara";
		}
		if($fila["prov_resid"] == 20){
			$provincia = "Guipuzcoa";
		}
		if($fila["prov_resid"] == 21){
			$provincia = "Huelva";
		}
		if($fila["prov_resid"] == 22){
			$provincia = "Huesca";
		}
		if($fila["prov_resid"] == 23){
			$provincia = "Jaén";
		}
		if($fila["prov_resid"] == 24){
			$provincia = "León";
		}
		if($fila["prov_resid"] == 25){
			$provincia = "Lleida";
		}
		if($fila["prov_resid"] == 26){
			$provincia = "La Rioja";
		}
		if($fila["prov_resid"] == 27){
			$provincia = "Lugo";
		}
		if($fila["prov_resid"] == 28){
			$provincia = "Madrid";
		}
		if($fila["prov_resid"] == 29){
			$provincia = "Málaga";
		}
		if($fila["prov_resid"] == 30){
			$provincia = "Murcia";
		}
		if($fila["prov_resid"] == 31){
			$provincia = "Navarra";
		}
		if($fila["prov_resid"] == 32){
			$provincia = "Ourense";
		}
		if($fila["prov_resid"] == 33){
			$provincia = "Asturias";
		}
		if($fila["prov_resid"] == 34){
			$provincia = "Palencia";
		}
		if($fila["prov_resid"] == 35){
			$provincia = "Las Palmas";
		}
		if($fila["prov_resid"] == 36){
			$provincia = "Pontevedra";
		}
		if($fila["prov_resid"] == 37){
			$provincia = "Salamanca";
		}
		if($fila["prov_resid"] == 38){
			$provincia = "Tenerife";
		}
		if($fila["prov_resid"] == 39){
			$provincia = "Cantabria";
		}
		if($fila["prov_resid"] == 40){
			$provincia = "Segovia";
		}
		if($fila["prov_resid"] == 41){
			$provincia = "Sevilla";
		}
		if($fila["prov_resid"] == 42){
			$provincia = "Soria";
		}
		if($fila["prov_resid"] == 43){
			$provincia = "Tarragona";
		}
		if($fila["prov_resid"] == 44){
			$provincia = "Teruel";
		}
		if($fila["prov_resid"] == 45){
			$provincia = "Toledo";
		}
		if($fila["prov_resid"] == 46){
			$provincia = "Valencia";
		}
		if($fila["prov_resid"] == 47){
			$provincia = "Valladolid";
		}
		if($fila["prov_resid"] == 48){
			$provincia = "Vizcaya";
		}
		if($fila["prov_resid"] == 49){
			$provincia = "Zamora";
		}
		if($fila["prov_resid"] == 50){
			$provincia = "Zaragoza";
		}
		if($fila["prov_resid"] == 51){
			$provincia = "Ceuta";
		}
		if($fila["prov_resid"] == 52){
			$provincia = "Melilla";
		}
			
		/* Comprobamos si hemos cambiado de provincia */
		if($provincia != $provinciaActual){
			$bool = false;
		}
		/* Si es la primera linea de cada provincia */
		if($bool == false){
			// Comprobamos si cambiamos de fichero
			if($yearActual != $fila["year"]){
				fputs($descFile, "\n{ \"Provincia\": \"".$provincia."\",       ");
				$yearActual = $fila["year"];
			}
			else{

				/* Escribimos la linea en la que definimos la provincia */
				fputs($descFile, "},\n{	\"Provincia\": \"".$provincia."\",	");
			}
			if($_POST["option1"] === "2Variables"){
				/* Escribimos la linea en la que instanciamos la provincia, teniendo en cuenta que es la primera instancia con 2 variables */
				$valor = $fila[$arrayCampos[count($arrayCampos)-2]];
				if($valor === "0"){
					$valor = "0.000001";
				}
				fputs($descFile, "\"".$cadenaConsultaJSON.$arrayCampos[count($arrayCampos)-2]."\": ".$valor.",	");
				$valor = $fila[$arrayCampos[count($arrayCampos)-1]];
				if($valor === "0"){
					$valor = "0.000001";
				}
				fputs($descFile, "\"".$cadenaConsultaJSON.$arrayCampos[count($arrayCampos)-1]."\": ".$valor);
			}
			else{
				$valor = $fila[$arrayCampos[count($arrayCampos)-1]];
				if($valor === "0"){
					$valor = "0.000001";
				}
				/* Escribimos la linea en la que instanciamos la provincia, teniendo en cuenta que es la primera instancia */
				fputs($descFile, "\"".$cadenaConsultaJSON."\": ".$valor);
			}

			$provinciaActual = $provincia;
			$bool = true;
		}
		else{
			if($_POST["option1"] === "2Variables"){
				/* Escribimos lineas en la que instanciamos la provincia cuando la linea no es la primera con dos variables*/
				$valor = $fila[$arrayCampos[count($arrayCampos)-2]];
				if($valor === "0"){
					$valor = "0.000001";
				}
				fputs($descFile, ",	\"".$cadenaConsultaJSON.$arrayCampos[count($arrayCampos)-2]."\": ".$valor);
				$valor = $fila[$arrayCampos[count($arrayCampos)-1]];
				if($valor === "0"){
					$valor = "0.000001";
				}
				fputs($descFile, ",	\"".$cadenaConsultaJSON.$arrayCampos[count($arrayCampos)-1]."\": ".$valor);
				
				
				
			}
			else{
				/* Escribimos lineas en la que instanciamos la provincia cuando la linea no es la primera*/
				$valor = $fila[$arrayCampos[count($arrayCampos)-1]];
				if($valor === "0"){
					$valor = "0.000001";
				}
				fputs($descFile, ",	\"".$cadenaConsultaJSON."\": ".$valor);

			}

		}
	}
}
// Cerramos los ficheros de JSON
$contador = $yearInicial;
while($yearFinal >= $contador){
	fputs($descriptores[$contador], "},\n]}");
	fclose($descriptores[$contador]);
	$contador++;
}

/*****************  FIN CREACION JSON DATOS ***************/


/**************************** INICIO JSON INTERVALOS **************************/
$cadena1 = "";

if($_POST["option1"] === "2Variables")
{
	for($i = 2; $i < count($arrayCampos) -2; $i++){
		$cadena1 = $cadena1.$arrayCampos[$i].", ";
	}
}
else
{
	for($i = 2; $i < count($arrayCampos) -1; $i++){
		$cadena1 = $cadena1.$arrayCampos[$i].", ";
	}
}

// Fichero de intervalos
$intervalosFile = fopen("/var/www/ecotrab_ecotrab/ProyectoVisualizacion/dojo-release-1.7.2-src/dojox/geo/charting/tests/datastore/intervalos.json" ,"w");
fputs($intervalosFile, "{	\"identifier\": \"instanciaCaracteristica\",	\"label\": \"instanciaCaracteristica\",	\"items\": [");
// obtenemos el nombre de la tabla de intervalos
$intervalosTabla = "Intervalos".$_POST["tema"];
echo($cadena1);
$Sql2 ="SELECT year, ".$cadena1."min_t, p20_t, p40_t, p60_t, p80_t, max_t FROM ".$intervalosTabla.";";
$result2 = mysql_query( $Sql2 ) or die("No se puede ejecutar la consulta: ".mysql_error());
// SOLO ENTRA UNA VEZ
while($Result2 = mysql_fetch_array($result2)) {

	$instanciaCaracteristica = $Result2["year"]."-";
	for($i = 2; $i < count($arrayCampos) -1; $i++){
		// Obtenemos la consulta JSON
		$instanciaCaracteristica = $instanciaCaracteristica.$arrayCampos[$i]."-".$Result2[$arrayCampos[$i]]."-";
	}
	fputs($intervalosFile, "\n{ \"instanciaCaracteristica\": \"".$instanciaCaracteristica."\",       \"min_t\":".$Result2["min_t"].", \"p20_t\":".$Result2["p20_t"].", \"p40_t\":".$Result2["p40_t"].", \"p60_t\":".$Result2["p60_t"].", \"p80_t\":".$Result2["p80_t"].", \"max_t\":".$Result2["max_t"]."},   ");
}
fputs($intervalosFile, "\n]}");
fclose($intervalosFile);
// Si tiene 2 variables, hacemos 2 fichero de intervalos distintos
if($_POST["option1"] === "2Variables"){
	// Fichero de intervalos
	$intervalosFile = fopen("/var/www/ecotrab_ecotrab/ProyectoVisualizacion/dojo-release-1.7.2-src/dojox/geo/charting/tests/datastore/intervalos.json" ,"w");
	fputs($intervalosFile, "{	\"identifier\": \"instanciaCaracteristica\",	\"label\": \"instanciaCaracteristica\",	\"items\": [");
	// obtenemos el nombre de la tabla de intervalos
	$intervalosTabla = "Intervalos".$_POST["tema"];
	echo($cadena1);
	$Sql2 ="SELECT year, ".$cadena1."min_t, p20_t, p40_t, p60_t, p80_t, max_t FROM ".$intervalosTabla.";";
	$result2 = mysql_query( $Sql2 ) or die("No se puede ejecutar la consulta: ".mysql_error());
	// SOLO ENTRA UNA VEZ
	while($Result2 = mysql_fetch_array($result2)) {

		$instanciaCaracteristica = $Result2["year"]."-";
		for($i = 2; $i < count($arrayCampos) -2; $i++){
			// Obtenemos la consulta JSON
			$instanciaCaracteristica = $instanciaCaracteristica.$arrayCampos[$i]."-".$Result2[$arrayCampos[$i]]."-";
		}
		fputs($intervalosFile, "\n{ \"instanciaCaracteristica\": \"".$instanciaCaracteristica."\",       \"min_t\":".$Result2["min_t"].", \"p20_t\":".$Result2["p20_t"].", \"p40_t\":".$Result2["p40_t"].", \"p60_t\":".$Result2["p60_t"].", \"p80_t\":".$Result2["p80_t"].", \"max_t\":".$Result2["max_t"]."},   ");
	}
	fputs($intervalosFile, "\n]}");
	fclose($intervalosFile);

	$intervalosFile = fopen("/var/www/ecotrab_ecotrab/ProyectoVisualizacion/dojo-release-1.7.2-src/dojox/geo/charting/tests/datastore/intervalos2.json" ,"w");
	fputs($intervalosFile, "{	\"identifier\": \"instanciaCaracteristica\",	\"label\": \"instanciaCaracteristica\",	\"items\": [");
	// obtenemos el nombre de la tabla de intervalos
	$intervalosTabla = "Intervalos".$_POST["tema"];
	$Sql2 ="SELECT year, ".$cadena1."min_t2, p20_t2, p40_t2, p60_t2, p80_t2, max_t2 FROM ".$intervalosTabla.";";
	$result2 = mysql_query( $Sql2 ) or die("No se puede ejecutar la consulta: ".mysql_error());
	// SOLO ENTRA UNA VEZ
	while($Result2 = mysql_fetch_array($result2)) {

		$instanciaCaracteristica = $Result2["year"]."-";
		for($i = 2; $i < count($arrayCampos) -2; $i++){
			// Obtenemos la consulta JSON
			$instanciaCaracteristica = $instanciaCaracteristica.$arrayCampos[$i]."-".$Result2[$arrayCampos[$i]]."-";
		}
		fputs($intervalosFile, "\n{ \"instanciaCaracteristica\": \"".$instanciaCaracteristica."\",       \"min_t\":".$Result2["min_t2"].", \"p20_t\":".$Result2["p20_t2"].", \"p40_t\":".$Result2["p40_t2"].", \"p60_t\":".$Result2["p60_t2"].", \"p80_t\":".$Result2["p80_t2"].", \"max_t\":".$Result2["max_t2"]."},   ");
	}
	fputs($intervalosFile, "\n]}");
	fclose($intervalosFile);
}
/* FIN JSON INTERVALOS */

/* Creamos el fichero del mapa */
$mapFile = fopen("/var/www/ecotrab_ecotrab/ProyectoVisualizacion/dojo-release-1.7.2-src/dojox/geo/charting/tests/mapFile.html" ,"w");
fputs($mapFile, "	<html>\n");
fputs($mapFile,"	<head>\n");
fputs($mapFile,"		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n");
fputs($mapFile,"		<title>Chart: Map&Chart</title>\n");
fputs($mapFile,"		<style type=\"text/css\">\n");
fputs($mapFile,"			@import \"../../../../dojo/resources/dojo.css\";\n");
fputs($mapFile,"			@import \"../../../../dijit/tests/css/dijitTests.css\";\n");
fputs($mapFile,"			@import \"../../../../dijit/themes/tundra/tundra.css\";\n");
fputs($mapFile,"			@import \"../resources/Map.css\";\n");
fputs($mapFile,"			.mapContainer {\n");
fputs($mapFile,"				display: none;\n");
fputs($mapFile,"				width: 810px;\n");
fputs($mapFile,"				height: 400px;\n");
fputs($mapFile,"				border: solid 1px;\n");
fputs($mapFile,"			}\n");
fputs($mapFile,"}\n");
fputs($mapFile,			".mapVerticalContainer {\n");
fputs($mapFile,				"display: none;\n");
fputs($mapFile,				"width: 405px;\n");
fputs($mapFile,				"height: 500px;\n");
fputs($mapFile,				"border: solid 1px;\n");
fputs($mapFile,			"}\n");
fputs($mapFile,		"@import \"{{baseUrl}}dojox/layout/resources/FloatingPane.css\";\n");
fputs($mapFile,		"@import \"{{baseUrl}}dojox/layout/resources/ResizeHandle.css\";\n");
fputs($mapFile,		"</style>\n");
fputs($mapFile,		"<script type=\"text/javascript\" djConfig=\"parseOnLoad:true,isDebug:true,gfxRenderer:'svg,canvas,vml,silverlight'\" src=\"../../../../dojo/dojo.js\"></script>\n");
fputs($mapFile,		"<script type=\"text/javascript\">\n");
fputs($mapFile,				"var isTouchDevice = dojo.isIos || (navigator.userAgent.toLowerCase().indexOf(\"android\") > -1)\n");
fputs($mapFile,				"|| (navigator.userAgent.toLowerCase().indexOf(\"blackberry\") > -1);\n");
fputs($mapFile,		"</script>\n");
fputs($mapFile,		"<script type=\"text/javascript\">\n");
fputs($mapFile,			"dojo.require(\"dojox.geo.charting.Map\");\n");
fputs($mapFile,                 "dojo.require(\"dojox.geo.charting.widget.Legend\");\n");
fputs($mapFile,			"dojo.require(\"dijit.layout.BorderContainer\");\n");
fputs($mapFile,"			dojo.require(\"dojox.charting.Chart\");\n");
fputs($mapFile,"			dojo.require(\"dojox.charting.axis2d.Default\");\n");
fputs($mapFile,"      			dojo.require(\"dojox.charting.plot2d.ClusteredBars\");\n");
fputs($mapFile,"			dojo.require(\"dojox.charting.plot2d.Grid\");\n");
fputs($mapFile,"			dojo.require(\"dojo.data.ItemFileReadStore\");\n");
fputs($mapFile,"			dojo.requireIf(isTouchDevice,\"dojox.geo.charting.TouchInteractionSupport\");\n");
fputs($mapFile,"			dojo.requireIf(!isTouchDevice,\"dojox.geo.charting.MouseInteractionSupport\");\n");
fputs($mapFile,"			dojo.require(\"dojox.geo.charting.KeyboardInteractionSupport\");\n");
fputs($mapFile,"			dojo.require(\"dojox.charting.themes.PlotKit.blue\");\n");
fputs($mapFile,"			dojo.require(\"dijit.form.RadioButton\");\n");
fputs($mapFile,"			dojo.require(\"dojox.layout.FloatingPane\");\n");
fputs($mapFile,'			dojo.require("dijit.form.Select");
							dojo.require("dojo.parser");
							dojo.require("dojox.charting.DataChart");
							dojo.require("dojo.data.ItemFileWriteStore");
							dojo.require("dijit.form.NumberSpinner");
');

fputs($mapFile,"			var store = new dojo.data.ItemFileReadStore({\n");
fputs($mapFile,"				url: \"datastore/fichero".$yearInicial.".json\"\n");
fputs($mapFile,"			});\n");

fputs($mapFile, 'var store2 = new dojo.data.ItemFileReadStore({
			url: "datastore/intervalos.json"
			});
			');
$variable = "";
if($_POST["option1"] === "2Variables")
{
	fputs($mapFile, 'var store3 = new dojo.data.ItemFileReadStore({
			url: "datastore/intervalos2.json"
			});
			');
	for($i = 2; $i < count($arrayCampos)-2; $i++){
		$variable = $variable.$arrayCampos[$i]."-99-";
	}
	$variable = $variable.$arrayCampos[count($arrayCampos)-2];
}
else
{
	for($i = 2; $i < count($arrayCampos)-1; $i++){
		$variable = $variable.$arrayCampos[$i]."-99-";
	}
}
fputs($mapFile,'var variable = "'.$variable.'";');
fputs($mapFile,"			dojo.addOnLoad(function(){\n");
/*************/
fputs($mapFile,'

var cols = new dojox.charting.DataChart("cols", {
				displayRange:60,
				scroll:false,
				xaxis:{labelFunc:"seriesLabels"},
				yaxis:{max:100},
				type: dojox.charting.plot2d.Columns
			});
			');
if($_POST["option1"] === "2Variables")
{
			fputs($mapFile, 'cols.setStore(store, {Provincia:"*"},"sexo-99-estud_gr-99-edad_gr-99-tocup");
			');
}
else{
	fputs($mapFile, 'cols.setStore(store, {Provincia:"*"},"sexo-99-estud_gr-99-edad_gr-99-");
			');
	
}

fputs($mapFile, '

changeProduct2 = function(Select){

	var splt = variable.split("-");
	var cadena = "";
	for(i = 0; i < splt.length -1; i = i + 2){
		var auxiliar = splt[i]+splt[i + 1];
		
		var selectSplit = Select.value.split("-");
		if(splt[i] === selectSplit[0]){
			auxiliar = splt[i] +"-"+ selectSplit[1]+"-";
				
		}
		else{
			auxiliar = splt[i]+"-"+splt[i + 1]+"-";
		}
		cadena = cadena + auxiliar;
	}
	');
if($_POST["option1"] === "2Variables")
{
	fputs($mapFile, 'variable = cadena + splt[splt.length-1];
	');
}
else{
	fputs($mapFile, 'variable = cadena;
');
}
fputs($mapFile, '
var valor = document.getElementsByName("select2")[0].value;
var consultaIntervalos = valor+"-"+cadena;
');
if($_POST["option1"] === "2Variables")
{
	fputs($mapFile, '
	if(String(document.getElementsByName("select3")[0].value) == "'.$arrayCampos[count($arrayCampos)-2].'"){
				auxStore = this.store2;
				}
				
			if(String(document.getElementsByName("select3")[0].value) == "'.$arrayCampos[count($arrayCampos)-1].'"){
				auxStore = this.store3;
				}
	');
}
else{
	fputs($mapFile, '
	auxStore = this.store2;
	');
	
	
}
fputs($mapFile, '

auxStore.fetchItemByIdentity({
				                        identity: consultaIntervalos,
				                        onItem: function(item){
				                        
map.addSeries([{
                                        name: auxStore.getValue(item, "min_t")+"-"+auxStore.getValue(item, "p20_t"),
                                        min: auxStore.getValue(item, "min_t")-1,
                                        max: auxStore.getValue(item, "p20_t"),
                                        color: "#01DFD7"
                                }, {
                                        name: auxStore.getValue(item, "p20_t")+"-"+auxStore.getValue(item, "p40_t"),
                                        min: auxStore.getValue(item, "p20_t"),
                                        max: auxStore.getValue(item, "p40_t"),
                                        color: "#0080FF"
                                }, {
                                        name: auxStore.getValue(item, "p40_t")+"-"+auxStore.getValue(item, "p60_t"),
                                        min: auxStore.getValue(item, "p40_t"),
                                        max: auxStore.getValue(item, "p60_t"),
                                        color: "#FFFF00"
                                }, {
                                        name: auxStore.getValue(item, "p60_t")+"-"+auxStore.getValue(item, "p80_t"),
                                        min: auxStore.getValue(item, "p60_t"),
                                        max: auxStore.getValue(item, "p80_t"),
                                        color: "#DF7401"
                                }, {
                                        name: auxStore.getValue(item, "p80_t")+"-"+auxStore.getValue(item, "max_t"),
                                        min: auxStore.getValue(item, "p80_t"),
                                        max: auxStore.getValue(item, "max_t")+1,
                                        color: "#DF0101"
                                }]);				
					
							}
							
						});
// PONER AQUI

	map.setDataBindingAttribute(variable);
	cols.setStore(store, {Provincia:"*"},variable);
	
	this.legend.destroy();
 
	this.legend = new dojox.geo.charting.widget.Legend({
					map: map
				});

};');
// CHANGEPRODUCT 4
if($_POST["option1"] === "2Variables"){
	fputs($mapFile,'
changeProduct4 = function(Select){

	var splt = variable.split("-");
	var cadena = "";
	for(i = 0; i < splt.length -1; i = i + 2){
		var auxiliar = splt[i]+splt[i + 1];
		
		var selectSplit = Select.value.split("-");
		if(splt[i] === selectSplit[0]){
			auxiliar = splt[i] +"-"+ selectSplit[1]+"-";
				
		}
		else{
			auxiliar = splt[i]+"-"+splt[i + 1]+"-";
		}
		cadena = cadena + auxiliar;
	}
	var valor = document.getElementsByName("select3")[0].value;
	variable = cadena + valor;
valor = document.getElementsByName("select2")[0].value;
var consultaIntervalos = valor+"-"+cadena;
');
			fputs($mapFile, '
			
			if(String(document.getElementsByName("select3")[0].value) == "'.$arrayCampos[count($arrayCampos)-2].'"){
				auxStore = this.store2;
				}
				
			if(String(document.getElementsByName("select3")[0].value) == "'.$arrayCampos[count($arrayCampos)-1].'"){
				auxStore = this.store3;
				}
				
				auxStore.fetchItemByIdentity({
				                        identity: consultaIntervalos,
				                        onItem: function(item){
				                        
map.addSeries([{
                                        name: auxStore.getValue(item, "min_t")+"-"+auxStore.getValue(item, "p20_t"),
                                        min: auxStore.getValue(item, "min_t")-1,
                                        max: auxStore.getValue(item, "p20_t"),
                                        color: "#01DFD7"
                                }, {
                                        name: auxStore.getValue(item, "p20_t")+"-"+auxStore.getValue(item, "p40_t"),
                                        min: auxStore.getValue(item, "p20_t"),
                                        max: auxStore.getValue(item, "p40_t"),
                                        color: "#0080FF"
                                }, {
                                        name: auxStore.getValue(item, "p40_t")+"-"+auxStore.getValue(item, "p60_t"),
                                        min: auxStore.getValue(item, "p40_t"),
                                        max: auxStore.getValue(item, "p60_t"),
                                        color: "#FFFF00"
                                }, {
                                        name: auxStore.getValue(item, "p60_t")+"-"+auxStore.getValue(item, "p80_t"),
                                        min: auxStore.getValue(item, "p60_t"),
                                        max: auxStore.getValue(item, "p80_t"),
                                        color: "#DF7401"
                                }, {
                                        name: auxStore.getValue(item, "p80_t")+"-"+auxStore.getValue(item, "max_t"),
                                        min: auxStore.getValue(item, "p80_t"),
                                        max: auxStore.getValue(item, "max_t")+1,
                                        color: "#DF0101"
                                }]);				
					
							}
						});
			
			
			
		');
			
		
	fputs($mapFile, '
	map.setDataStore(this.store, variable);

// PONER AQUI
	map.setDataBindingAttribute(variable);
	cols.setStore(store, {Provincia:"*"},variable);
	this.legend.destroy();
 
	this.legend = new dojox.geo.charting.widget.Legend({
					map: map
				});

};
');
}

//CHANGE PRODUCT 3:
fputs($mapFile,'
changeProduct3 = function(Select){

	this.store = new dojo.data.ItemFileReadStore({
				url: "datastore/fichero"+Select.value+".json"
				
			});
	
	//map.setDataStore(this.store, variable);
	var splt = variable.split("-");
var cadena = "";
for(i = 0; i < splt.length -1; i = i + 2){
	var auxiliar = splt[i]+splt[i + 1];
	var selectSplit = Select.value.split("-");
	if(splt[i] === selectSplit[0]){
		auxiliar = splt[i] +"-"+ selectSplit[1]+"-";
			
	}
	else{
		auxiliar = splt[i]+"-"+splt[i + 1]+"-";
	}
	cadena = cadena + auxiliar;
}
');

if($_POST["option1"] === "2Variables")
{
	fputs($mapFile, 'variable = cadena + splt[splt.length-1];
	');
	//fputs($mapFile, 'variable = cadena;
//');
	
}
else{
	fputs($mapFile, 'variable = cadena;
');
	
}
fputs($mapFile, '
//variable = variable+splt[splt.length-1];

//variable = cadena;
var consultaIntervalos = Select.value+"-"+cadena;

');
if($_POST["option1"] === "2Variables")
{
	fputs($mapFile, '
	if(String(document.getElementsByName("select3")[0].value) == "'.$arrayCampos[count($arrayCampos)-2].'"){
				auxStore = this.store2;
				}
				
			if(String(document.getElementsByName("select3")[0].value) == "'.$arrayCampos[count($arrayCampos)-1].'"){
				auxStore = this.store3;
				}
	');
}
else{
	fputs($mapFile, '
	auxStore = this.store2;
	');
	
	
}
fputs($mapFile, '

auxStore.fetchItemByIdentity({
				                        identity: consultaIntervalos,
				                        onItem: function(item){
map.addSeries([{
                                        name: auxStore.getValue(item, "min_t")+"-"+auxStore.getValue(item, "p20_t"),
                                        min: auxStore.getValue(item, "min_t")-1,
                                        max: auxStore.getValue(item, "p20_t"),
                                        color: "#01DFD7"
                                }, {
                                        name: auxStore.getValue(item, "p20_t")+"-"+auxStore.getValue(item, "p40_t"),
                                        min: auxStore.getValue(item, "p20_t"),
                                        max: auxStore.getValue(item, "p40_t"),
                                        color: "#0080FF"
                                }, {
                                        name: auxStore.getValue(item, "p40_t")+"-"+auxStore.getValue(item, "p60_t"),
                                        min: auxStore.getValue(item, "p40_t"),
                                        max: auxStore.getValue(item, "p60_t"),
                                        color: "#FFFF00"
                                }, {
                                        name: auxStore.getValue(item, "p60_t")+"-"+auxStore.getValue(item, "p80_t"),
                                        min: auxStore.getValue(item, "p60_t"),
                                        max: auxStore.getValue(item, "p80_t"),
                                        color: "#DF7401"
                                }, {
                                        name: auxStore.getValue(item, "p80_t")+"-"+auxStore.getValue(item, "max_t"),
                                        min: auxStore.getValue(item, "p80_t"),
                                        max: auxStore.getValue(item, "max_t")+1,
                                        color: "#DF0101"
                                }]);				
					
							}
						});
// PONER AQUI
map.setDataStore(this.store, variable);
	map.setDataBindingAttribute(variable);
	cols.setStore(store, {Provincia:"*"},variable);
	this.legend.destroy();
 
	this.legend = new dojox.geo.charting.widget.Legend({
					map: map
				});

};');

fputs($mapFile,"				var map = new dojox.geo.charting.Map(\"map\", \"../resources/data/Spain.json\");\n");
fputs($mapFile,"if (!isTouchDevice) {\n");
fputs($mapFile,"					var mouseInteraction = new dojox.geo.charting.MouseInteractionSupport(map,{enablePan:true,enableZoom:true});\n");
fputs($mapFile,"					mouseInteraction.connect();\n");
fputs($mapFile,"				} else {\n");
fputs($mapFile,"					var touchInteraction = new dojox.geo.charting.TouchInteractionSupport(map,{});\n");
fputs($mapFile,"					touchInteraction.connect();\n");
fputs($mapFile,"				}\n");
fputs($mapFile,"				var keyboardInteraction = new dojox.geo.charting.KeyboardInteractionSupport(map, {enableZoom: true});\n");
fputs($mapFile,"				keyboardInteraction.connect();\n");

fputs($mapFile,'map.setDataStore(store, "'.$variable.'");');
// Cadena que ira despues del where con valores de todos

$afterWhere = "";
if($_POST["option1"] === "2Variables"){
	for ($i = 2; $i < count($arrayCampos) -2; $i++) {
		$afterWhere = $afterWhere.$arrayCampos[$i]."=99 AND ";
	}
}
else {
	for ($i = 2; $i < count($arrayCampos) -1; $i++) {
		$afterWhere = $afterWhere.$arrayCampos[$i]."=99 AND ";
	}
}
$Sql2 ="SELECT * FROM ".$intervalosTabla." WHERE ".$afterWhere."year=".$yearInicial.";";
$result2 = mysql_query( $Sql2 ) or die("No se puede ejecutar la consulta: ".mysql_error());

// SOLO ENTRA UNA VEZ
while($Rs2 = mysql_fetch_array($result2)) {


	fputs($mapFile, '			map.addSeries([{
					name: "'.$Rs2["min_t"].'-'.$Rs2["p20_t"].'",
					min: "'.$Rs2["min_t"].'"-1,
					max: "'.$Rs2["p20_t"].'",
					color: "#01DFD7"
				}, {
					name: "'.$Rs2["p20_t"].'-'.$Rs2["p40_t"].'",
					min: "'.$Rs2["p20_t"].'",
					max: "'.$Rs2["p40_t"].'",
					color: "#0080FF"
				}, {
					name: "'.$Rs2["p40_t"].'-'.$Rs2["p60_t"].'",
					min: "'.$Rs2["p40_t"].'",
					max: "'.$Rs2["p60_t"].'",
					color: "#FFFF00"
				}, {
					name: "'.$Rs2["p60_t"].'-'.$Rs2["p80_t"].' ",
					min: "'.$Rs2["p60_t"].'",
					max: "'.$Rs2["p80_t"].'",
					color: "#DF7401"
				}, {
					name: "'.$Rs2["p80_t"].'-'.$Rs2["max_t"].'",
					min: "'.$Rs2["p80_t"].'",
					max: "'.$Rs2["max_t"].'"+1,
					color: "#DF0101"
				}]);
				
				');

}

fputs($mapFile,"this.legend = new dojox.geo.charting.widget.Legend({\n");
fputs($mapFile,"					map: map\n");
fputs($mapFile,"				});\n");
fputs($mapFile,"				map.onFeatureOver = function(feature){\n");
fputs($mapFile,'					    var valor = document.getElementsByName("select2")[0].value;');

fputs($mapFile, '										
										store.fetchItemByIdentity({
				                        identity: feature.id,
				                        onItem: function(item){
				                        	if(store.getValue(item, variable) == undefined){
				                        		feature.markerText = feature.id + ": " + "conjunto vacio";
				                        	}
				                        	else if(store.getValue(item, variable) == "0.000001"){
				                        		feature.markerText = feature.id + ": " + "0";
				                        	}
				                        	else{
				                        		feature.markerText = feature.id + ": " + store.getValue(item,variable);
				                        	}
			                        	}
				                        });
											
');
										
fputs($mapFile,"				};\n");
fputs($mapFile,"			});\n");


fputs($mapFile,"		</script>\n");
fputs($mapFile,"	</head>\n");
fputs($mapFile,'	<body class="tundra">

				<h1>Datos sobre '.$_POST["tema"].'</h1>
						<p>Situa el cursor sobre la provincia para obtener sus datos</p>
						<table>
						<tr>
						<td>
						<div style="width:610px;height:400px;border:solid 1px;background:#f5f5f5;" id="map">;
						</div>
						</td>
						<td>
						<div   >
'
);

/*******************/
$contadorArray = 0;
for($i = 2; $i < count($arrayCampos) -1; $i++){
	//fputs($mapFile,"		        <tr>\n");

	$Sql2 ="SELECT nombre, descripcion FROM Medidas WHERE nombre='".$arrayCampos[$i]."'";
	$result2 = mysql_query( $Sql2 ) or die("No se puede ejecutar la consulta: ".mysql_error());
	// Obtenemos el valor de la consulta --> solo 1
	while($Rs2 = mysql_fetch_array($result2)) {
		//fputs($mapFile,"                        <td><label>\"".$arrayCampos[$i]."\"</label></td>\n");

		$desc = split(",",$Rs2['descripcion']);
		fputs($mapFile,'
<select name="select1" data-dojo-type="dijit.form.Select" onchange="changeProduct2(this)">');
		for($j=0;$j<count($desc);$j++){
			$desc2 = split(":",$desc[$j]);
			//fputs($mapFile,'                                <td><input type="radio" dojoType="dijit.form.RadioButton" name="'.$arrayCampos[$i].'" id="'.$Rs2['nombre'].$desc2[0].'"\n');
			if($j < count($desc) -1){
				fputs($mapFile,'<option value="'.$Rs2['nombre']."-".$desc2[0]. '" >'.$desc2[1].'</option>');
			}
			else{
				fputs($mapFile,'<option value="'.$Rs2['nombre']."-".$desc2[0]. '" selected="selected">'.$desc2[1].'</option>');
			}
			$contadorArray++;
		}
		fputs($mapFile, '</select><br><br>');
	}
}
if($_POST["option1"] === "2Variables"){
	fputs($mapFile, '<select name="select3" data-dojo-type="dijit.form.Select" onchange="changeProduct4(this)">
	');
	for($i = count($arrayCampos) - 2;$i <= count($arrayCampos) - 1; $i++){
		fputs($mapFile,'<option value="'.$arrayCampos[$i].'" >'.$arrayCampos[$i].'</option>');
	}
	fputs($mapFile, '</select><br><br>');

}


fputs($mapFile, '
<select name="select2" size="5" data-dojo-type="dijit.form.Select" onchange="changeProduct3(this)">
');
$contador = $yearInicial;
while($contador <= $yearFinal){
	fputs($mapFile, '<option value="'.$contador.'" >'.$contador.'</option>
	');
	$contador++;
}
fputs($mapFile,'</select>

');

fputs($mapFile,"				</div>\n");
fputs($mapFile,'		</div>
			
			</td>
			</tr>
			</table>
			<div id="cols"></div></tr>
			
			'

);
fputs($mapFile,"	</body>\n");
fputs($mapFile,"</html>\n");


fclose($mapFile);



?>
<html>
<head>

<meta http-equiv="Refresh"
	content="1;url=http://localhost/ecotrab_ecotrab/ProyectoVisualizacion/dojo-release-1.7.2-src/dojox/geo/charting/tests/mapFile.html">

</head>
<body>

Redireccionando al mapa. En caso de error pulsa
<a
	href="http://localhost/ecotrab_ecotrab/ProyectoVisualizacion/dojo-release-1.7.2-src/dojox/geo/charting/tests/mapFile.html">aqui</a>
</body>
</html>
