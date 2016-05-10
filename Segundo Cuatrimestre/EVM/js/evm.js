

/************* Funciones de Usuarios ************/

function toggleResponsables(){
	var select = $("#select_responsable");
	var text = $("#input_tipoRelación");
	if(select.attr('disabled')){
		select.removeAttr('disabled');
		text.removeAttr('disabled');
	} else {
		select.attr({
			'disabled': 'disabled'
		});
		text.attr({
			'disabled': 'disabled'
		});
	}
}

function buscadorUsuarios(){
	var buscador = document.getElementById("buscador");
	var input = buscador.value;
	var xhttp; 
	if (window.XMLHttpRequest) {
    	xhttp = new XMLHttpRequest();
    } else {
    	// code for IE6, IE5
    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
    if (input.length == 0) { 
        document.getElementById("suggestions").autocomplete = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("suggestions").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "../tratamientos/buscadorUsuarios.php?q=", true);
        xmlhttp.send();
    }
	
}

/************************************************/