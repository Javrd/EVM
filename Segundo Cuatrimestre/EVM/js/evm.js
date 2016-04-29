

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

/************************************************/