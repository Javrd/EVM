
function nuevaAsignatura(){
	document.getElementById("overlay").className = document.getElementById("overlay").className.replace("hidden", "");
	document.getElementById("nuevaAsignatura").className = document.getElementById("overlay").className.replace("hidden", "");
}

function cancelaNuevaAsignatura(){
	document.getElementById("overlay").className += "hidden";
	document.getElementById("nuevaAsignatura").className += "hidden";
}