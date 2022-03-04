select
	tem.id id_temporada,
	tem.nombre temporada,
	usu.id id_usuario,
	usu.nombre usuario,
	usu.cedula,
	alm.nombre almacen,
	sum(case when con.id = 1 then ecu.puntos else 0 end) acumulados_2017,
	sum(case when con.id = 3 then ecu.puntos else 0 end) CalculoTrimestral,
	sum(case when con.id = 4 then ecu.puntos else 0 end) CalculoTrimestralEspecial,
	sum(case when con.id = 5 then ecu.puntos else 0 end) Cancelaciones,
	sum(case when con.id = 6 then ecu.puntos else 0 end) Ajustes,
	sum(case when con.id = 2 then ecu.puntos else 0 end) redenciones
from
	estado_cuenta ecu
	inner join conceptos con on con.id = ecu.id_concepto
	inner join periodo per on per.id = ecu.id_periodo
	inner join temporadas tem on tem.id = per.id_temporada
	inner join usuarios usu on ecu.id_usuario = usu.id
	inner join almacenes alm on alm.id = usu.id_almacen
group by
	tem.id,
	tem.nombre,
	usu.nombre,
	usu.cedula,
	alm.nombre
order by	
	alm.nombre,
	usu.nombre,
	tem.id