<?php
# CLASE PARA GESTIONAR LA BASE DE DATOS
class mysql{ 
    private $localhost = "localhost";    
    private $usuario = "root";
    private $password = "";
    private $database = "couchinn";
	
 public function conectar(){
 	if(!isset($this->conexion)){
    	$this->conexion = new mysqli($this->localhost, $this->usuario,$this->password,$this->database) or die(mysql_error());
    }
 }     
 
 public function consulta($q){
    $resultado = $this->conexion->query($q);
    if(!$resultado){
     	echo 'MySQL Error en consulta: ' . mysql_error();
     	exit;
    }
    return $resultado; 
 }
 
 function numero_de_filas($result){
 // if(!is_resource($result)) 
  //          return false;
  return $result->num_rows;
 } 
}
?>
