function fncMostrar()
{
	div=document.getElementById("divResultado");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	empresa=document.getElementById('idempresa').value;
	periodoContable=document.getElementById('idperiodo_contable').value;
	strParam="empresa="+empresa+"&periodoContable="+periodoContable+"&mostrarActivoCorriente=1";
	ajax_dynamic_div("POST",'gen_balance_general_get.php',strParam,div,'false');
}

function fncCambiarMonto(id, monto)
{
	
	div=document.getElementById("divActualizar");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	strParam="id="+id+"&monto="+monto+"&actualizarDetalle=1";
	ajax_dynamic_div("POST",'gen_balance_general_update.php',strParam,div,'false');
	fncMostrar();
}

function fncAgregarCuenta(opt,id,monto)
{
	
	if (document.getElementById('cuenta_'+opt).value > 0)
	{
		div=document.getElementById("divActualizar");
		$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
		strParam="id="+id+"&monto="+monto+"&cuenta="+document.getElementById('cuenta_'+opt).value+"&agregarDetalle=1";
		ajax_dynamic_div("POST",'gen_balance_general_update.php',strParam,div,'false');
		fncMostrar();
	}
	else
	{
		alert('Elegir Cuenta');
	}
}

function fncCambiarCuenta(opt,id,monto){
	
	if(monto>0){
		if (document.getElementById('monto_'+opt).value > 0){
			fncAgregarCuenta(opt,id,document.getElementById('monto_'+opt).value);
		}
	}
}