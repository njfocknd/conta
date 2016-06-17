function fncMostrarBalance()
{
	empresa=document.getElementById('idempresa').value;
	periodoContable=document.getElementById('idperiodo_contable').value;
	div=document.getElementById("divBalance");
	$(div).html("");
	strParam="empresa="+empresa+"&periodoContable="+periodoContable+"&mostrarBalance=1";
	ajax_dynamic_div("POST",'balance_get.php',strParam,div,'false');
}

function fncAgregar(x)
{
 	balance=document.getElementById('pBalanceGeneral').value;
	if(x ==1)
	{
		grupoCuenta=document.getElementById('inputGrupoCuentaCirculanteA').value;
		claseCuenta=document.getElementById('inputClaseCuentaActivo').value;
		subGrupoCuenta=document.getElementById('idsubgrupo_cuentaAc').value;
		monto=document.getElementById('montoAc').value;
	}
	else if(x ==2)
	{
		grupoCuenta=document.getElementById('inputGrupoCuentaCirculanteP').value;
		claseCuenta=document.getElementById('inputClaseCuentaPasivo').value;
		subGrupoCuenta=document.getElementById('idsubgrupo_cuentaPc').value;
		monto=document.getElementById('montoPc').value;
	}
	else if(x ==3)
	{
		grupoCuenta=document.getElementById('inputGrupoCuentaFijoA').value;
		claseCuenta=document.getElementById('inputClaseCuentaActivo').value;
		subGrupoCuenta=document.getElementById('idsubgrupo_cuentaAf').value;
		monto=document.getElementById('montoAf').value;
	}
	else
	{
		grupoCuenta=document.getElementById('inputGrupoCuentaFijoP').value;
		claseCuenta=document.getElementById('inputClaseCuentaPasivo').value;
		subGrupoCuenta=document.getElementById('idsubgrupo_cuentaPf').value;
		monto=document.getElementById('montoPf').value;
	}
	div=document.getElementById("divUpdate");
 	$(div).html("Balance General");
	if(monto < '0.01')
	{
		alert("El Monto es igual o menor a 0.00");
	}
	else if((subGrupoCuenta=== undefined) || (subGrupoCuenta == '')|| (subGrupoCuenta == ' ')|| (subGrupoCuenta == null))
	{
		alert("No hay más cuentas para agregar");
	}
	else
	{
		strParam="balance="+balance+"&grupoCuenta="+grupoCuenta+"&claseCuenta="+claseCuenta+"&subGrupoCuenta="+subGrupoCuenta+"&monto="+monto+"&agregar=1";
		ajax_dynamic_div("POST",'balance_get.php',strParam,div,'false');
	}
}

function fncAgregarPeriodo()
{
	alert();
}