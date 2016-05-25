

/************* Funciones de Comunes ************/

function checkDate(){
	
	var selectDia = document.getElementById('select_dia');
	var selectMes = document.getElementById('select_mes');
	var selectAnio = document.getElementById('select_anio');
	
	var groupDia = selectDia.getElementsByTagName("optgroup").item(0);
	
	
	var dia = selectDia.value;
	var mes = selectMes.value;
	var anio = selectAnio.value;
	
	if(mes== 01 || mes== 03 || mes== 05 || mes== 07 || mes== 08 || mes== 10 || mes== 12){ // Enero, Marzo, Mayo, Julio, Agosto, Octubre y Diciembre, meses con 31 dias
		if (selectDia.length<31){
			for (var i = selectDia.length+1; i<=31; i++){
				var option = document.createElement("option");
				option.text=""+i;
				groupDia.appendChild(option);
			}
		}
	} else	if(mes== 04 || mes == 06 || mes == 09 || mes == 11){ // Abril, Junio, Septiembre y Noviembre, meses con 30 dias
		if (dia==31){
			selectDia.value = 30;
		}
		if (selectDia.length<30){
			for (var i = selectDia.length+1; i<=30; i++){
				var option = document.createElement("option");
				option.text=""+i;
				groupDia.appendChild(option);
			}
		} else if (selectDia.length>30){
			selectDia.remove(30);
		}
	} else if(mes==02) {
		
		if (anio%400==0 || (anio%100!=0 && anio%4==0)){ //Bisiesto
			if (selectDia.length==28){
				var option = document.createElement("option");
				option.text=""+29;
				groupDia.appendChild(option)(option);
			} else if (selectDia.length>29){
				if (dia>29)
					selectDia.value = 29;
				for (var i = selectDia.length-1; i>28; i--){
					selectDia.remove(i);
				}
			}
		} else {
			if (selectDia.length>28){
				if (dia>28)
					selectDia.value = 28;
				for (var i = selectDia.length-1; i>27; i--){
					selectDia.remove(i);
				}
			}
		}
	}
}

/************************************************/