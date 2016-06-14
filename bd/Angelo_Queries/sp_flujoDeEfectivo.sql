set @año1 = '2014';
set @año2 = '2015';
set @idcuenta_efectivo=6;

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
	inner join periodo_contable periodo on balance.idperioso_contable=periodo.idperiodo_contable
	inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
where
	periodo.nombre=@año1 or periodo.nombre=@año2
group by
	clase.nombre,
	grupo.nombre,
	subgrupo.nombre 
