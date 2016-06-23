function cargarCiudades(){
	var list = document.getElementById("ciudad");
	list.add(new Option("items[i].text", "items[i].value"));

}

$(document).ready(function() {
  $(".select2").select2({
  	    placeholder: "Seleccione una categoría",
    maximumSelectionLength: 1
  });
   $(".selectCiudad").select2({
  	placeholder:"Seleccione una ciudad",
    maximumSelectionLength: 1
  });
   $(".selectProvincia").select2({
  	placeholder:"Seleccione una provincia",
    maximumSelectionLength: 1
  });
   $( ".selectProvincia" ).change(function() {
  		cargarCiudades();	
	});
});

	function validar_campo(elem){
		if (elem.value.length < 3) {
			elem.style.borderColor = "red"
		}
	}
	function limpiar(elem){
		//var foo = document.getElementById('titulo');
	elem.style.borderColor='#FFFFFF';// this.style.color='#FFFFFF';		
	}
	 function valida(){ 
        var f = new Date();
		var dia= f.getDate();       if(dia<10) dia= "0"+dia;
		var mes= f.getMonth() + 1;  if(mes<10) mes= "0"+mes;
		var anio= f.getFullYear();
        var hoy=(anio + "-" + mes + "-" + dia);	  
	    valor = document.getElementById("titulo").value;
	   	if (valor.length < 3) {
			alert ('ERROR! Debe ingresar un título válido!');
			return false;
		}
		valor = document.getElementById("direccion").value;
		if (valor.length < 3) {
			alert ('ERROR! Debe ingresar una dirección válida!');
			return false;
		}
		if (!document.getElementById("fecha_inicio").value){
			alert ('ERROR! Debe seleccionar una fecha de inicio!');
			return false;
		}
			
			
		if (document.getElementById("fecha_inicio").value < hoy){			
			alert ('ERROR! La fecha de inicio debe ser igual o posterior a hoy!');
			return false;
		}
					
		if (document.getElementById("fecha_inicio").value>=document.getElementById("fecha_fin").value
		 && document.getElementById("fecha_fin").value!=""
		){
			alert ('ERROR! La fecha de fin debe ser mayor a la de inicio!');
			return false;
		}
				
		if (!document.getElementById("tipo").value){
			alert ('ERROR! Debe seleccionar una categoría!');
			return false;
		}
		if (!document.getElementById("provincia").value){
			alert ('ERROR! Debe seleccionar una provincia!');
			return false;
		}
		if (!document.getElementById("ciudad").value){
			alert ('ERROR! Debe seleccionar una ciudad!');
			return false;
		} 
		if (document.getElementById("total_img").value==0 && document.getElementById("fotoss").value=='no'){
			alert ('ERROR! Debe tener al menos una foto!');
			return false;
		} 
		 
		
		valor = document.getElementById("descripcion").value;
		if (valor.length < 3) {
			alert ('ERROR! Debe ingresar una descripción!');
		return false;
		}
		
	document.getElementById('enviar_todo').value= "si";
	document.registro.submit();
	}
	
	//Activo las imagenes que tengo
	function enviar_imagenes(){
		document.getElementById('imagenes_previas').value= "si";
		document.getElementById('total_img').value= 0;
		document.registro.submit();
		}
		
	

	//Cancela multiples imagenes		
		function cancela_multiples(){
			if(confirm('Está seguro de cancelar todas las imágenes?')){
				  document.getElementById('total_img').value= 0;
				  document.getElementById('imagenes_previas').value= "no";
			  document.registro.submit();
			  }
			}



		function enviar_provincia(){
		document.registro.submit();
		}
		
	function validarTodo(){
		document.registro.submit();
		//location.href="index.php";
		}
	
	
	
	
	
	
	  //Para el modificarImagen::::::::
	 function seguroCambiaImagen(){
	 alert("seguro");
	 document.getElementById('fotoss').value='no';
	 document.registro.submit();
	 }

	
	
	