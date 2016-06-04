// JavaScript Document


function validar_nombre(input, valor , tipo){
     
	 if(input.value.length==0){
	  //document.getElementById('nombre_incorrecto').innerHTML = '<p>   Falta este campo';  
	   //document.getElementById('nombre_usuario').style="border-color:#F00";
	    document.getElementById(input.id).type=tipo;
	   document.getElementById(input.id).value=valor;
	   document.getElementById(input.id).style="color:#888;";
	 }
	}
	

function vaciar_nombre(input,valor, tipo){
	 if(input.value== valor){
		   document.getElementById(input.id).value="";
		   document.getElementById(input.id).style="color:#000;";
		 }
	   
	   document.getElementById(input.id).type=tipo;
	}	
	
	
	function validar_clave(input){ 
	
	}
	
	
    function validar_clave2(input){
     
	
		
	}

	
	function seleccionar(input){
		
		document.registro.m.checked=false;
	    document.registro.f.checked=false;
	 	
	   	input.checked=true;	
		}
		
		
		
		
			
function justNumbers(e){ 
	  if (event.keyCode < 47 || event.keyCode > 57)
	   return false; 
	  return true;
        }// JavaScript Document



function sin_espacio(e){ 
	  if (event.keyCode == 32)
	   return false; 
	  return true;
        }






/////////////////////Esto valida los campos de Alta USUARIO:::



function validar_vacio(input, valor){
	 if(valor==input || input ==""){
	   return false;
	   }
	   else return true;
	}

function validar_seis(input){
	 
	 if(input.length<6){
	   return false;
	   }
	   else return true;
	}

	
function claves_iguales(input,input2){
	 if(input!=input2){
	   return false;
	   }
	   else return true;
	}	
		
function validar_fecha(input){
	 	 
	 if(input.length==0){
		 
	   return false;
	   }
	   anio=input.substring(0,4);
	  if(anio<1900 ||  anio>2014){
		   return false;
		  } 
	   
	    return true;
	
	
	}	

function validar_sin_espacios(input){
	 if (/\s/.test(input)) { return false; }
	 return true;
	}




		
function validar_campos_retorno(){
	var uno=[];
	 uno[1]= validar_vacio(document.registro.nombre_usuario.value , "Nombre de usuario");
	
	 uno[2]= validar_seis(document.registro.nombre_usuario.value );
	
	 uno[3]= validar_vacio(document.registro.clave.value , "Clave");
	 uno[4]= validar_seis(document.registro.clave.value );

	 uno[5]= claves_iguales(document.registro.clave.value, document.registro.clave2.value );
   
     uno[6]= validar_fecha(document.registro.fecha_nacimiento.value );
	

	
	if(uno[1]==false){ 
	  
	   document.getElementById('nombre_usuario').style="border-color:#F00";
	    alert("Nombre usuario vacío"); 
		return false;
	 }
	
	if(uno[2]==false){ 
	    document.getElementById('nombre_usuario').style="border-color:#F00";
	    alert("El nombre de usuario tiene que tener al menos 6 caracteres"); 	
	     return false;
	       }
	
	if(uno[3]==false){        	  
	   document.getElementById('clave').style="border-color:#F00";
	    alert("Clave usuario vacía"); 	
	     return false;
		  }	
	
	if(uno[4]==false){ 
	    document.getElementById('clave').style="border-color:#F00";
	    alert("La Clave de usuario tiene que tener al menos 6 caracteres"); 	
	     return false;
	       }
	if(uno[5]==false){ 
	    document.getElementById('clave').style="border-color:#F00";
		document.getElementById('clave2').style="border-color:#F00";
	    alert("Las claves tienen que ser iguales"); 	
	     return false;
	       }
		   
		  
		
		if(uno[6]==false){ 
	    document.getElementById('fecha_nacimiento').style="border-color:#F00";
	    alert("Tiene que tener una fecha válida"); 	
	     return false;
	       }
	   
	     if(validarEmail(document.registro.email.value)==false){
			 return false;
			 }
	   
	   	return true;	
	
	  
	}
	
	
	function validar_campos(){
		if(validar_campos_retorno()==true)
		   document.registro.submit();
		}
	
	
	////////////-------------------------
	
	


	  function validar_opcionales(){
           document.registro.submit();

	  }
	
	
	
	
	/////////////Esto valida los opcionales:::::
	
	function validarEmail( email ) {
   
   
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(email=="" || email=="Email (con @extension. )"){
		document.getElementById('email').style="border-color:#F00";
		alert("Tiene que tener una direccion de E-mail");
		return false;
		}
	  
	
	if ( !expr.test(email) ){
		document.getElementById('email').style="border-color:#F00";
        alert("Error: La dirección de correo es incorrecta.");
		
	    return false;
	}


}
	
	


		
		/////En caso de cancelar el registro de usuario esto pregunta para mas seguridad:
		  function seguro(destino){
			   
               confirmar=confirm("¿SEGURO QUE QUIERE CANCELAR SU REGISTRO?"); 
                   if (confirmar) {
					
                    location.href= destino; }   
            } 
		

		
			
function nobackbutton(){
	
   window.location.hash="no-back-button";
	
   window.location.hash="Again-No-back-button" //chrome
	
   window.onhashchange=function(){window.location.hash="no-back-button";}
	
}
	
	
	
	
	
	
	
	
	//Funcion para modificar usuario::
	function validar_modificar(){
		// if(validar_campos_retorno()==true  && validar_opcionales_retorno()==true)
              document.registro.submit();	 
		   
		}
		
		
		
		
		
