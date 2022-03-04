set @id_temporada = 3;
set @lija_seca = 0;
set @ejecutar = 0;
set @id_periodo_final = (select max(id) from periodo where id_temporada = @id_temporada);

drop temporary table if exists t_cuotas;
create temporary table if not exists t_cuotas as (

	select
		tem.id id_temporada,
		usu.id_almacen,
		usu.id id_usuario,
		sum(cuo.cuota) cuota
	from
		cuotas cuo
		inner join usuarios usu on usu.id = cuo.id_usuario
		inner join periodo per on per.id = cuo.id_periodo
		inner join temporadas tem on tem.id = per.id_temporada
	where
		cuo.lija_seca = @lija_seca
		and tem.id = @id_temporada
	group by
		tem.id,
		usu.id
	
);

drop temporary table if exists t_ventas;
create temporary table if not exists t_ventas as (

	select
		tem.id id_temporada,
		usu.id_almacen,
		usu.id id_usuario,
		sum(ven.venta) venta
	from
		ventas ven
		inner join usuarios usu on usu.id = ven.id_usuario
		inner join periodo per on per.id = ven.id_periodo
		inner join temporadas tem on tem.id = per.id_temporada
	where
		ven.lija_seca = @lija_seca
		and tem.id = @id_temporada
	group by
		tem.id,
		usu.id,
		usu.id_almacen
	
);

select * from t_ventas;

drop temporary table if exists t_cumplimiento;
create temporary table if not exists t_cumplimiento as (

	select
		cuo.id_almacen,
		cuo.id_temporada,
		cuo.id_usuario,
		cuo.cuota,
		ven.venta,
		round((ven.venta * 100) / cuo.cuota) cumplimiento
	from 	
		t_cuotas cuo
		inner join t_ventas ven on 
			ven.id_temporada = cuo.id_temporada
			and ven.id_usuario = cuo.id_usuario
		
);

drop temporary table if exists t_puntos;
create temporary table if not exists t_puntos as (

	select
		tem.id id_temporada,
		tem.nombre temporada,
		alm.id id_almacen,
		alm.nombre almacen,
		usu.id id_usuario,
		usu.cedula,
		usu.nombre usuario,
		cuota,
		venta,
		cumplimiento,
		case
			when usu.id in (598,587) then 
				case
					when cumplimiento >= 100 then round(venta / 5000)
					else 0
				end
			when usu.id in (290,706) then 
				case
					when cumplimiento >= 100 then round(venta / 10000)
					else 0
				end
			else		
				case
					when cumplimiento >= 100 and @lija_seca = 0 then round(venta / alm.divisor_calculo)
					when cumplimiento >= 100 and @lija_seca = 1 then round(venta / 1000)
					else 0
				end
		end puntos
	from 
		t_cumplimiento cum
		inner join temporadas tem on tem.id = cum.id_temporada
		inner join usuarios usu on usu.id = cum.id_usuario
		left join almacenes alm on alm.id = usu.id_almacen
	where
		(
			(@lija_seca = 0 and usu.id not in (select id_usuario from estado_cuenta where id_periodo = @id_periodo_final and id_concepto = 3))
			or (@lija_seca = 1 and usu.id not in (select id_usuario from estado_cuenta where id_periodo = @id_periodo_final and id_concepto = 4))
		)
	order by
		tem.id,
		alm.id desc,
		usu.id

);

select 
	*, 
	case 
		when id_almacen <> 34 then puntos 
		else round((puntos * 90) / 100) 
	end puntos_reales
from t_puntos;

insert into estado_cuenta(id_periodo,id_concepto,id_usuario,puntos,descripcion,fecha)
select
	@id_periodo_final id_periodo,
	case when @lija_seca = 0 then 3 else 4 end id_concepto,
	id_usuario,	
	case 
		when id_almacen <> 34 then puntos 
		else round((puntos * 90) / 100) 
	end puntos,
	concat("Calculo ",temporada) descripcion,
	now() fecha
from
	t_puntos
where
	@ejecutar = 1;

	
/*
select * from t_puntos;
select * from t_cumplimiento;
select * from t_ventas;
select * from t_cuotas;

set @id_usuario_especifico = 598;
select * from t_puntos where id_usuario in (@id_usuario_especifico);
select * from t_cumplimiento where id_usuario in (@id_usuario_especifico);
select * from t_ventas where id_usuario in (@id_usuario_especifico);
select * from t_cuotas where id_usuario in (@id_usuario_especifico);
*/

drop table t_puntos;
drop table t_cumplimiento;
drop table t_ventas;
drop table t_cuotas;