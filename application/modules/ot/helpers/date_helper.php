<?php
//Entrada:
 // $fecha: Valor de la fecha a comparar
 // $fecha_compara: Fecha con la que se establecerá la comparación, si no se establece una fecha se comparara con la fecha actual. por defecto NULL
 //Salida: BOLEAN, si las fechas son iguales se devuelve 0, si la primer fecha es menor a la segunda se devuelve -1, si la primer fecha es mayor a la segunda se devuelve 1.
 //Nota: Esta función puede devolver el valor booleano FALSE, pero también puede devolver un valor no booleano que se evalúa como FALSE. Use el operador === para comprobar el valor devuelto por esta función.
 //Autor: dantepiazza
 //Version: 1.0
 
function comparar_fechas($fecha, $fecha_comparar = null){
 if($fecha_comparar == null){
  $fecha_comparar = date("Y-m-d H:i:s");
 }
 
 $fecha = strtotime($fecha);
 $fecha_comparar = strtotime($fecha_comparar);
 
 if($fecha == $fecha_comparar){  
  return 0;
 }
 else if($fecha < $fecha_comparar){  
  return -1;
 }
 else if($fecha > $fecha_comparar){    
  return 1;
 }
 
 return false;
}
?>