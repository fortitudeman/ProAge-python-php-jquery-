<?php

//Función para saber si todos las fechas dentro del archivo son iguales.
function is_valid_date($tmp_file){
	//cargamos el archivo
	$lineas = file($tmp_file);

	//inicializamos variable a 0, esto nos ayudará a indicarle que no lea la primera línea
	$i=0;
	$correcto = false;
	//Recorremos el bucle para leer línea por línea
	foreach ($lineas as $linea_num => $linea){
	   //abrimos bucle
	   /*si es diferente a 0 significa que no se encuentra en la primera línea
	   (con los títulos de las columnas) y por lo tanto puede leerla*/
	   if($i != 0){
		   //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
		   /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá
		   leyendo hasta que encuentre un , */
		   $datos = explode(",",$linea);
		   //Almacenamos los datos que vamos leyendo en una variable
		   //usamos la función utf8_encode para leer correctamente los caracteres especiales
		   $fecha = ($datos[0]);
		   $mes = $datos[1];
	   }

	   /*Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya
	   entraremos en la condición, de esta manera conseguimos que no lea la primera línea.*/
	   $i++;
	   //cerramos bucle
	}
}
?>