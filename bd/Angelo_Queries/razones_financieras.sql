


#Parametros
set @idempresa:=2;
#cuentas balance general
set @idinventarios:=9;
set @idcuentaefectivo:=6;
set @iddeuda_largo_plazo := 36;
set @idcuentas_x_cobrar:=7;

select 
	idperiodo_contable into @idperiodo 
from 
	periodo_contable 
where 
	nombre='2015';

/*--Datos de estados de resultados--*/
select
	resultado.venta_netas,resultado.costo_ventas,resultado.depreciacion,
	resultado.venta_netas -  resultado.costo_ventas - resultado.depreciacion, #Utilidades Antes de los Intereses e Impuestos
	resultado.interes_pagado,resultado.utilidad_neta
	 into 
	 @ventas,@costos,@depreciacion,
	 @uaii,
	 @intereses_pagados, @utilidad_neta
from 
	estado_resultado resultado
where
	resultado.idempresa=@idempresa
	and resultado.idperiodo_contable=@idperiodo;
	
/*--Datos de estados del balance general--*/
select 
	balance.activo_circulante+balance.activo_fijo, 
	balance.pasivo_circulante+balance.pasivo_fijo,
	balance.activo_circulante-balance.pasivo_circulante,
	(balance.activo_circulante + balance.activo_fijo)-(balance.pasivo_circulante + balance.pasivo_fijo),
	(@activo_total-@capital_contable)/(@activo_total),
	sum(if(detalle.idsubgrupo_cuenta=@idinventarios, detalle.monto, 0)),
	sum(if(detalle.idsubgrupo_cuenta=@idcuentaefectivo,detalle.monto,0)),
	sum(if(detalle.idsubgrupo_cuenta=@iddeuda_largo_plazo,detalle.monto,0)),
	sum(if(detalle.idsubgrupo_cuenta=@idcuentas_x_cobrar,detalle.monto,0))
	into
	@activo_total,
	@pasivo_total,
	@capital_trabajo,
	@capital_contable,
	@deuda_total,	
	@inventarios,
	@efectivo,
	@deuda_largo_plazo,
	@cuentas_x_cobrar
from 
	balance_general balance
	inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
where
	balance.idempresa=@idempresa 
	and balance.idperiodo_contable=@idperiodo
group by
	balance.activo_circulante,
	balance.activo_fijo,
	balance.pasivo_circulante,
	balance.pasivo_fijo;
/*----------------------RAZONES FINANCIERAS------------------*/
select 
	#-----Medidas de liquidez a corto plazo
	round(balance.activo_circulante/balance.pasivo_circulante,2) AS razon_circulante,
	round((balance.activo_circulante-@inventarios)/balance.pasivo_circulante,2) AS razon_rapida,
	round(@efectivo/balance.pasivo_circulante,2) as razon_de_efectivo,
	round((@capital_trabajo/@activo_total)*100,2) AS "cap_trab_neto%",
	floor(balance.activo_circulante/(@costos/365)) AS medida_intervalo,
	#-----Medidas de liquidez a largo plazo o de apalancamiento 
	round(@deuda_total,2) as deuda_total,
	round(@deuda_total/(1-@deuda_total),2) as razon_deuda_capital,
	round(1/(1-@deuda_total),2) as multiplicador_capital,
	round(@deuda_largo_plazo/(@deuda_largo_plazo+@capital_contable),2)  as deuda_largo_plazo,
	round(@uaii / @intereses_pagados,2) as veces_interes_ganado,
	round((@uaii + @depreciacion)/@intereses_pagados,2) as cobertura_efectivo,
	 #-----Medidas de actividad o rotacion de activos
	 round(@costos/@inventarios,2) as rotacion_inventario,
	 floor(365/(@costos/@inventarios)) as dias_venta_inventario,
	 round(@ventas/@cuentas_x_cobrar,2) as rotacion_cuentas_x_cobrar,
	 floor(365/(@ventas/@cuentas_x_cobrar)) as dias_ventas_cxc,
	 round(@ventas/@capital_trabajo,2) as rotacion_capital_trabajo,
	 round(@ventas/balance.activo_fijo,2) as rotacion_activos_fijos,
	 round(@ventas/@activo_total,2) as rotacion_activo_total,
	 #Medidas de rentabilidad
	 round((@utilidad_neta / @ventas)*100,2) as "margen_utilidad%",
	 round((@utilidad_neta / @activo_total)*100,2) as "rendimiento_activos%",
	 round((@utilidad_neta / @capital_contable)*100,2) as "rendimiento_sobre_capital%"
from 
	balance_general balance
	inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
where
	balance.idempresa=@idempresa 
	and balance.idperiodo_contable=@idperiodo
group by
	balance.activo_circulante,
	balance.pasivo_circulante;
	
