window.onload = function(){
/*check if is on decktop backend and show fron-page options*/
	var section=document.getElementsByClassName("wrap");
	var str = section[0]['baseURI'];
	var res = str.split("/");
    //console.log(res[res.length-2]);
	if(res[res.length-2]==="wp-admin"&&res[res.length-1]==='index.php'||res[res.length-2]==="wp-admin"&&res[res.length-1]===''){
  		var element = document.getElementById("custom-admin-section");
  		element.classList.add("show-element");

	}

/*Change footer*/
	document.getElementById("footer-thankyou").innerHTML = "Creado por <a href='https://buhodigital.net' target='_blank'> BuhoDigital.net</a>";	

/*Eliminar Links del panel*/
	var a = document.getElementsByTagName('a');
	for(var i = 0; i < a.length; i++){
	    if(a[i].innerText == 'Actualizaciones' || a[i].textContent == 'Actualizaciones'){
	        a[i].parentNode.removeChild(a[i]);      
	    }
	}	
}

/****datos fuera de prevent onload****/

/*agregar campos*/
	function recuadro(abrir_cerrar){
		if(abrir_cerrar==="abrir"){
		 var ac="block";
		}else{
		 var ac="none";
		}
	document.getElementById("recuadro").style.display = ac;
	}

	function textOrFile(value){
		switch(value) {
		  case "texto":
		     document.getElementById("contenido-txt").style.display="block";
		     document.getElementById("contenido-url").style.display="none";
		    break;
		  case ("url"):
		  	 document.getElementById("contenido-txt").style.display="none";
		     document.getElementById("contenido-url").style.display="block";
		    break;
		  default:
		    // code block
		}

	}

	/*Confirmar antes de borrar registro*/
	function confirm_del(formsubmitdel) {
		if (window.confirm("¿Está seguro que desea eliminar el registro seleccionado?")) {
		   	   location.href = "index.php?formsubmitdel=" + formsubmitdel;
		}


}	

function copiar(id){      
  // Crea un input para poder copiar el texto dentro      
  let copyText = document.getElementById(id).innerText
  const textArea = document.createElement('textarea');
  textArea.textContent = copyText;
  document.body.append(textArea);      
  textArea.select();      
  document.execCommand("copy");      
  // Delete created Element      
  textArea.remove();
  alert('Se ha copiado la función correctamente');
} 
