function fncGetTable(){
	day=document.getElementById('fecha').value;
	fecha = day.substring(6,10)+day.substring(3,5)+day.substring(0,2);
	div=document.getElementById("div_table");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	div2=document.getElementById("div_table2");
	$(div2).html("<img src='nexthor/image/loading.gif' align='center'>");
	str_param="fecha="+fecha;
	ajax_dynamic_div("POST",'app_get.php',str_param,div);
	
	ajax_dynamic_div("POST",'app_pub_get.php',str_param,div2);
}