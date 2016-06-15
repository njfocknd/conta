set @año1 = '2014';
set @año2 = '2015';
set @idcuenta_efectivo=6;
set @idempresa=2;

select 
	@idflujo_efectivo:=f.idflujo_efectivo
from 
	flujo_efectivo f
	inner join periodo_contable p on f.idperiodo_contable=p.idperiodo_contable
where 
	f.idempresa=2 and p.nombre=@año2;

#Inserta efectivo
insert into flujo_efectivo_detalle (idflujo_efectivo, idgrupo_flujo_efectivo,monto)
select 
	@idflujo_efectivo,
	1, #idgrupoefectivo	
	detalle.monto 		
from 
	balance_general balance
	inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
	inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta 	
	inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
	inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
	inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
where
   balance.idempresa=@idempresa and	periodo.nombre=@año1
   and subgrupo.idsubgrupo_cuenta=6; #cuenta de efectivo

#Insertar Utilidad


#Insertar depreciacion


#insertar cuentas de actividad de operacion



#insertar cuentas de actividad de inversion



#insertar cuentas de actividad de financiamiento







select 
	#clase.idclase_cuenta,
	clase.nombre,
	#grupo.idgrupo_cuenta,
	grupo.nombre,
	#subgrupo.idsubgrupo_cuenta,
	subgrupo.nombre ,
	sum(case @año1 
		when periodo.nombre then detalle.monto 
		else 0
	end) as Año1,
	sum(case @año2 
		when periodo.nombre then detalle.monto 
		else 0
	end) as Año2,
	sum(case @año2 
		when periodo.nombre then detalle.monto 
		else 0
	end)-	sum(case @año1 
		when periodo.nombre then detalle.monto 
		else 0
	end) AS Cambio
	
from 
	balance_general balance
	inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
	inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta 	
	inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
	inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
	inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
where
   balance.idempresa=@idempresa and	(periodo.nombre=@año1 or periodo.nombre=@año2)
group by
	clase.nombre,
	grupo.nombre,
	subgrupo.nombre;
	
	
select 
	@UtilidadNeta := resultado.utilidad_neta ,
	@DividendosPagados := resultado.dividendos,
	@AccionesRetenidas := resultado.utilidades_retenidas
from
	estado_resultado resultado
	inner join periodo_contable periodo on resultado.idperiodo_contable=periodo.idperiodo_contable
where 
	resultado.idempresa=@idempresa and periodo.nombre=@año2;

select 
	@UtilidadNeta,@DividendosPagados,@AccionesRetenidas