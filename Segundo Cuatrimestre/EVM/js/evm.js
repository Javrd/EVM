

/************* Funciones de Comunes ************/

function checkDate(){
	
	var selectDia = document.getElementById('select_dia');
	var selectMes = document.getElementById('select_mes');
	var selectAnio = document.getElementById('select_anio');
	
	var dia = selectDia.value;
	var mes = selectMes.value;
	var anio = selectAnio.value;
	
	if(mes== 04 || mes == 06 || mes == 09 || mes == 11){ // Abril, Junio, Septiembre y Noviembre, meses con 30 dias
		if (dia==31)
			selectDia.value = 30;
	}
}

/************************************************/