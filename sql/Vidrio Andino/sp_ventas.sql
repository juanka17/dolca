drop procedure if exists sp_ventas;

DELIMITER //

create procedure sp_ventas(lija_seca_p int)
begin

	drop temporary table if exists t_cuotas;
	create temporary table if not exists t_cuotas as (
	
		select
			tem.id id_temporada,
			per.id id_periodo,
			usu.id id_usuario,
			sum(cuo.cuota) cuota
		from
			cuotas cuo
			inner join usuarios usu on usu.id = cuo.id_usuario
			inner join periodo per on per.id = cuo.id_periodo
			inner join temporadas tem on tem.id = per.id_temporada
		where
			cuo.lija_seca = lija_seca_p
		group by
			tem.id,
			usu.id,
			per.id
		
	);
	
	drop temporary table if exists t_ventas;
	create temporary table if not exists t_ventas as (
	
		select
			tem.id id_temporada,
			usu.id id_usuario,
			per.id id_periodo,
			sum(ven.venta) venta
		from
			ventas ven
			inner join usuarios usu on usu.id = ven.id_usuario
			inner join periodo per on per.id = ven.id_periodo
			inner join temporadas tem on tem.id = per.id_temporada
		where
			ven.lija_seca = lija_seca_p
		group by
			tem.id,
			usu.id,
			per.id
		
	);
	
	select
		usu.id id_usuario,
		usu.cedula,
		usu.nombre,
		alm.nombre almacen,
		tem.nombre temporada,
		per.nombre periodo,
		cuo.cuota,
		ifnull(ven.venta,0) venta
	from 	
		t_cuotas cuo
		inner join periodo per on per.id = cuo.id_periodo
		inner join temporadas tem on tem.id = per.id_temporada
		inner join usuarios usu on usu.id = cuo.id_usuario
		inner join almacenes alm on alm.id = usu.id_almacen
		left join t_ventas ven on 
			ven.id_temporada = cuo.id_temporada
			and ven.id_usuario = cuo.id_usuario
			and ven.id_periodo = cuo.id_periodo
	order by
		tem.id,
		per.id;
			
end //

delimiter ;

call sp_ventas(0);