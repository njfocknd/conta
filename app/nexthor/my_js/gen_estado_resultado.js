function fncMostrar()
{
	div=document.getElementById("divResultado");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	empresa=document.getElementById('idempresa').value;
	periodoContable=document.getElementById('idperiodo_contable').value;
	strParam="empresa="+empresa+"&periodoContable="+periodoContable+"&mostrarResultado=1";
	ajax_dynamic_div("POST",'gen_estado_resultado_get.php',strParam,div,'false');
}

function fncProyectar(id)
{
	div=document.getElementById("divActualizar");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	idempresa_proyectar=document.getElementById('idempresa_proyectar').value;
	idperiodo_contable_proyectar=document.getElementById('idperiodo_contable_proyectar').value;
	aumento=document.getElementById('aumento').value;
	strParam="id="+id+"&idempresa_proyectar="+idempresa_proyectar+"&idperiodo_contable_proyectar="+idperiodo_contable_proyectar+"&aumento="+aumento+"&proyectar=1";
	ajax_dynamic_div("POST",'gen_estado_resultado_update.php',strParam,div,'false');
	fncMostrar();
}

function fncCambiarMonto(id, monto)
{
	div=document.getElementById("divActualizar");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	strParam="id="+id+"&monto="+monto+"&actualizarDetalle=1";
	ajax_dynamic_div("POST",'gen_estado_resultado_update.php',strParam,div,'false');
	fncMostrar();
}

function fncAgregarCuenta(id,monto)
{
	if (document.getElementById('cuenta').value > 0)
	{
		div=document.getElementById("divActualizar");
		$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
		strParam="id="+id+"&monto="+monto+"&cuenta="+document.getElementById('cuenta').value+"&agregarDetalle=1";
		ajax_dynamic_div("POST",'gen_estado_resultado_update.php',strParam,div,'false');
		fncMostrar();
	}
	else
	{
		alert('Elegir Cuenta');
	}
}

function fncCambiarCuenta(id,monto){
	if(monto>0){
		if (document.getElementById('monto').value > 0){
			fncAgregarCuenta(id,document.getElementById('monto').value);
		}
	}
}