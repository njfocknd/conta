function fncContarDescarga(x)
{
	valor = document.getElementById("btnDescarga_"+x).innerHTML;
	document.getElementById("btnDescarga_"+x).innerHTML=parseInt(valor)+parseInt(1);
}

function fncCambio(x)
{
	id=document.getElementById('id_articulo').value;
	document.getElementById("botonFoto").className = "btn btn-default";
	document.getElementById("botonSinFoto").className = "btn btn-default";
	div=document.getElementById("x");
	$(div).html("");
	if(x == 1)
	{
		document.getElementById("botonFoto").className = "btn btn-success";
		strParam="articulo="+id+"&updateImagen=1";
		ajax_dynamic_div("POST",'imprimir_nota_get.php',strParam,div,'false');
	}
	else
	{
		document.getElementById("botonSinFoto").className = "btn btn-success";
	}
		
}
function delay(){
    setTimeout('afterFiveSeconds()',5000)
}

function afterFiveSeconds(){
    fncCambio(1);
}
function fncCheckStar(x,star,p_attachment)
{
	if(x==1)
	{
		for (i = 1; i < star+1; i++) 
		{ 
			document.getElementById("bs"+i+"_"+p_attachment).className = "btn btn-warning btn-xs";
			document.getElementById("s"+i+"_"+p_attachment).className = "glyphicon glyphicon-star";
		}	
	}
	else
	{
		for (i = 1; i < star+1; i++) 
		{ 
			document.getElementById("bs"+i+"_"+p_attachment).className = "btn btn-default btn-xs";
			document.getElementById("s"+i+"_"+p_attachment).className = "glyphicon glyphicon-star-empty";
		}
	}
}

function fncCheckStarOk()
{
	
}

function fncCalificar(x,id) // si x = 2 descalifica; si x=1 califica   No se usara desde las 10:50 16/05/2016
{
	div=document.getElementById("divCalificacion");
	$(div).html("");
	strParam="articulo="+id+"&updateImagenCalificacion="+x;
	ajax_dynamic_div("POST",'imprimir_nota_get.php',strParam,div,'false');
}

function fncReserva(articulo,user,x)
{
	div=document.getElementById("divCalificacion");
	$(div).html("");
	strParam="articulo="+articulo+"&usuario="+user+"&updateReserva="+x;
	//alert(strParam);
	ajax_dynamic_div("POST",'imprimir_nota_get.php',strParam,div,'false');
}

function fncActualizaCalificacion(id,x) // x=1 opcion para calificar   x=2 opcion para descalificar
{
	if(x==2)//recien calificada
	{
		document.getElementById('btnCalificar_'+id).onclick = "fncCalificar('2,"+id+"')";
		document.getElementById('btnCalificar_'+id).className = "btn btn-success btn-xs";
		document.getElementById('btnCalificar_'+id).title = "Click para des-calificar fotografía";
	}
	else
	{
		document.getElementById('btnCalificar_'+id).onclick = "fncCalificar('1,"+id+"')";
		document.getElementById('btnCalificar_'+id).className = "btn btn-danger btn-xs";
		document.getElementById('btnCalificar_'+id).title = "Click para Calificar fotografía";
	}
}

function fncActualizaBotonReserva(articulo,usuario,reserva)//reserva =2 ya se reservo  reserva=1 se quito reserva
{
	if(reserva == 1)
	{
		document.getElementById('botonReservar').value = "Reservar";
		document.getElementById('botonReservar').className = "btn btn-warning";
		document.getElementById("botonReservar").disabled = true;
	}
	else
	{
		document.getElementById('botonReservar').value = "Reservado";
		document.getElementById('botonReservar').className = "btn btn-danger";
		document.getElementById("botonReservar").disabled = true;
	}
	 
}
