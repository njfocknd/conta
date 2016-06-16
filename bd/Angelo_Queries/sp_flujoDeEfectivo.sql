


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
		
delete from flujo_efectivo_detalle where idflujo_efectivo =@idflujo_efectivo;

#Obtiene los datos del estado de resultados
select 
	@UtilidadNeta := resultado.utilidad_neta ,
	@Depreciacion := resultado.depreciacion,
	@DividendosPagados := resultado.dividendos,
	@AccionesRetenidas := resultado.utilidades_retenidas
from
	estado_resultado resultado
	inner join periodo_contable periodo on resultado.idperiodo_contable=periodo.idperiodo_contable
where 
	resultado.idempresa=@idempresa and periodo.nombre=@año2;


#Inserta efectivo
set @idgrupoefectivo:=1;
insert into flujo_efectivo_detalle (idflujo_efectivo, idgrupo_flujo_efectivo,idsubgrupo_cuenta_balance,monto)
select 
	@idflujo_efectivo,
	@idgrupoefectivo, 
	subgrupo.idsubgrupo_cuenta,
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

#*******************actividad de operacion*************************

#Insertar Utilidad
set @idgrupoefectivo:=2; 
insert into flujo_efectivo_detalle 
	(idflujo_efectivo, idgrupo_flujo_efectivo,descripcion,monto)
values
	(@idflujo_efectivo,@idgrupoefectivo,'Utilidad neta',@UtilidadNeta);

#Insertar depreciacion
set @idgrupoefectivo:=2; 
insert into flujo_efectivo_detalle 
	(idflujo_efectivo, idgrupo_flujo_efectivo,descripcion,monto)
values
	(@idflujo_efectivo,@idgrupoefectivo,'Depreciacion',@Depreciacion );


#Inserta Cuentas de operacion

#cuentas de activo
insert into flujo_efectivo_detalle 
	(idflujo_efectivo, idgrupo_flujo_efectivo,idsubgrupo_cuenta_balance,monto)
select 
	@idflujo_efectivo,
	efectivo.idgrupo_flujo_efectivo,
	subgrupo.idsubgrupo_cuenta,
	sum(case @año1 
		when periodo.nombre then detalle.monto 
		else 0
	end)-
	sum(case @año2 
		when periodo.nombre then detalle.monto 
		else 0
	end)	
from 
	balance_general balance
	inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
	inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta
	inner join grupo_flujo_efectivo efectivo on subgrupo.idgrupo_flujo_efectivo=efectivo.idgrupo_flujo_efectivo 	
	inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
	inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
	inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
where
   balance.idempresa=@idempresa and	(periodo.nombre=@año1 or periodo.nombre=@año2)
   and clase.idclase_cuenta=1 #ACTIVO
group by
	subgrupo.nombre,
	efectivo.idgrupo_flujo_efectivo;


#cuentas de pasivo
insert into flujo_efectivo_detalle 
	(idflujo_efectivo, idgrupo_flujo_efectivo,idsubgrupo_cuenta_balance,monto)
select 
	@idflujo_efectivo,
	efectivo.idgrupo_flujo_efectivo,
	subgrupo.idsubgrupo_cuenta,
	sum(case @año2 
		when periodo.nombre then detalle.monto 
		else 0
	end)-
	sum(case @año1 
		when periodo.nombre then detalle.monto 
		else 0
	end)
from 
	balance_general balance
	inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
	inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta
	inner join grupo_flujo_efectivo efectivo on subgrupo.idgrupo_flujo_efectivo=efectivo.idgrupo_flujo_efectivo 	
	inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
	inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
	inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
where
   balance.idempresa=@idempresa and	(periodo.nombre=@año1 or periodo.nombre=@año2)
   and clase.idclase_cuenta=3 #PASIVO
group by
	subgrupo.nombre,
	efectivo.idgrupo_flujo_efectivo;
	
	
#cuentas de capital
insert into flujo_efectivo_detalle 
	(idflujo_efectivo, idgrupo_flujo_efectivo,idsubgrupo_cuenta_balance,monto)
select 
	@idflujo_efectivo,
	efectivo.idgrupo_flujo_efectivo,
	subgrupo.idsubgrupo_cuenta,
	sum(case @año2 
		when periodo.nombre then detalle.monto 
		else 0
	end)-
	sum(case @año1 
		when periodo.nombre then detalle.monto 
		else 0
	end)
from 
	balance_general balance
	inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
	inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta
	inner join grupo_flujo_efectivo efectivo on subgrupo.idgrupo_flujo_efectivo=efectivo.idgrupo_flujo_efectivo 	
	inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
	inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
	inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
where
   balance.idempresa=@idempresa and	(periodo.nombre=@año1 or periodo.nombre=@año2)
   and clase.idclase_cuenta=5 #capital
group by
	subgrupo.nombre,
	efectivo.idgrupo_flujo_efectivo;
	
	
#Insertar Depreciaciones
set @idgrupoefectivo:=3; 
insert into flujo_efectivo_detalle 
	(idflujo_efectivo, idgrupo_flujo_efectivo,descripcion,monto)
values
	(@idflujo_efectivo,@idgrupoefectivo,'Depreciacion',@Depreciacion*-1 );


	

#Insertar Dividendo
set @idgrupoefectivo:=4; 
insert into flujo_efectivo_detalle 
	(idflujo_efectivo, idgrupo_flujo_efectivo,descripcion,monto)
values
	(@idflujo_efectivo,@idgrupoefectivo,'Dividendos pagados',@DividendosPagados*-1 );
