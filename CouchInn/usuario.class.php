<?php
# CLASE USUARIO PARA GESTIONAR A LOS USUARIOS DEL SISTEMA

require_once 'mysql.class.php';

class usuario extends mysql
{
  #Cuando se crea el objeto se realiza la conexion a la base de datos 
  public function __construct()
  {
    $this->conectar();
  }
  public function validar_ingreso($usuario=NULL,$password=NULL){
    if( $usuario!=null and $password!=null){
        # se limpian variables
        $usuario = htmlspecialchars(trim($usuario), ENT_QUOTES);        
        $password = htmlspecialchars(trim($password), ENT_QUOTES);
		
        # se realiza la consulta a la base de datos
        $r = $this->consulta("SELECT * FROM usuarios WHERE nombredeusuario='".($usuario)."' AND clave='".($password)."' ");
        # retorna resultado en boolean
        return ( $this->numero_de_filas($r)>0) ? true : false ;          
    }
    else
        return false;    
  }  
  public function admin($usuario=NULL){
    if( $usuario!=null){
        $result = $this->consulta("SELECT admin FROM usuarios WHERE nombredeusuario='".$usuario."'");
		$row=$result->fetch_array();
        return ( $row[0]==1) ? true : false ;          
    }
    else
        return false;   
         
  } 
  public function esPremium($usuario=NULL){
    if( $usuario!=null){
        $result = $this->consulta("SELECT destacado FROM usuarios WHERE nombredeusuario='".$usuario."'");
    $row=$result->fetch_array();
        return ( $row[0]==1) ? true : false ;          
    }
    else
        return false;    
  }  
}
