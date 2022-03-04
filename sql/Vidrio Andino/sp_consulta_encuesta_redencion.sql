drop procedure if exists sp_consulta_encuesta_redencion;

DELIMITER //

create procedure sp_consulta_encuesta_redencion()
begin
	
	drop table if exists t_redenciones;
	create table t_redenciones (
	
		select distinct
			alm.nombre almacen,
			usu.nombre usuario,
			usu.cedula,
			red.id id_redencion,
			per.nombre periodo,
			pre.nombre premio,
			ope.nombre operacion,
			red.fecha fecha_redencion
		from 
			encuesta_redencion enc
			inner join redenciones red on red.id = enc.id_redencion
			inner join premios pre on pre.id = red.id_premio
			inner join seguimiento_redencion seg on seg.id = red.id_ultima_operacion
			inner join operaciones_redencion ope on ope.id = seg.id_operacion
			inner join usuarios usu on usu.id = red.id_usuario
			inner join periodo per on per.id = red.id_periodo
			inner join almacenes alm on alm.id = usu.id_almacen
		
	);
	
	drop table if exists t_encuestas;
	create table t_encuestas (
	
		select
			red.id_redencion,
			red.almacen,
			red.usuario,
			red.cedula,
			red.periodo,
			red.premio,
			red.operacion,
			red.fecha_redencion,
			enc.fecha fecha_encuesta,
			max(case when enc.numero_pregunta = 1 then enc.respuesta else '' end) p1,
			max(case when enc.numero_pregunta = 2 then enc.respuesta else '' end) p2,
			max(case when enc.numero_pregunta = 3 then enc.respuesta else '' end) p3,
			max(case when enc.numero_pregunta = 4 then enc.respuesta else '' end) p4,
			max(case when enc.numero_pregunta = 5 then enc.respuesta else '' end) p5,
			max(case when enc.numero_pregunta = 6 then enc.respuesta else '' end) p6,
			max(case when enc.numero_pregunta = 7 then enc.respuesta else '' end) p7,
			max(case when enc.numero_pregunta = 8 then enc.respuesta else '' end) p8,
			max(case when enc.numero_pregunta = 9 then enc.respuesta else '' end) p9,
			trim(replace(group_concat(enc.comentario order by enc.id),',',' ')) comentarios
		from 
			t_redenciones red
			inner join encuesta_redencion enc on enc.id_redencion = red.id_redencion
		group by
			red.id_redencion,
			red.almacen,
			red.usuario,
			red.cedula,
			red.periodo,
			red.premio,
			red.operacion,
			red.fecha_redencion,
			enc.fecha
		order by
			red.id_redencion,
			enc.numero_pregunta
		
	);
	
	select
		enc.id_redencion,
		enc.almacen,
		enc.usuario,
		enc.cedula,
		enc.periodo,
		enc.premio,
		enc.operacion,
		enc.fecha_redencion,
		enc.fecha_encuesta,
		case 
			when enc.p1 = 0 then 'No'
			when enc.p1 = 1 then 'Si'
			when enc.p1 = 4 then 'Excelente'
			when enc.p1 = 3 then 'Buena'
			when enc.p1 = 2 then 'Regular'
			else ''
		end pregunta1,
		case 
			when enc.p2 = 0 then 'No'
			when enc.p2 = 1 then 'Si'
			when enc.p2 = 4 then 'Excelente'
			when enc.p2 = 3 then 'Buena'
			when enc.p2 = 2 then 'Regular'
			else ''
		end pregunta2,
		case 
			when enc.p3 = 0 then 'No'
			when enc.p3 = 1 then 'Si'
			when enc.p3 = 4 then 'Excelente'
			when enc.p3 = 3 then 'Buena'
			when enc.p3 = 2 then 'Regular'
			else ''
		end pregunta3,
		case 
			when enc.p4 = 0 then 'No'
			when enc.p4 = 1 then 'Si'
			when enc.p4 = 4 then 'Excelente'
			when enc.p4 = 3 then 'Buena'
			when enc.p4 = 2 then 'Regular'
			else ''
		end pregunta4,
		case 
			when enc.p5 = 0 then 'No'
			when enc.p5 = 1 then 'Si'
			when enc.p5 = 4 then 'Excelente'
			when enc.p5 = 3 then 'Buena'
			when enc.p5 = 2 then 'Regular'
			else ''
		end pregunta5,
		case 
			when enc.p6 = 0 then 'No'
			when enc.p6 = 1 then 'Si'
			when enc.p6 = 4 then 'Excelente'
			when enc.p6 = 3 then 'Buena'
			when enc.p6 = 2 then 'Regular'
			else ''
		end pregunta6,
		case 
			when enc.p7 = 0 then 'No'
			when enc.p7 = 1 then 'Si'
			when enc.p7 = 4 then 'Excelente'
			when enc.p7 = 3 then 'Buena'
			when enc.p7 = 2 then 'Regular'
			else ''
		end pregunta7,
		case 
			when enc.p8 = 0 then 'No'
			when enc.p8 = 1 then 'Si'
			when enc.p8 = 4 then 'Excelente'
			when enc.p8 = 3 then 'Buena'
			when enc.p8 = 2 then 'Regular'
			else ''
		end pregunta8,
		case 
			when enc.p9 = 0 then 'No'
			when enc.p9 = 1 then 'Si'
			when enc.p9 = 4 then 'Excelente'
			when enc.p9 = 3 then 'Buena'
			when enc.p9 = 2 then 'Regular'
			else ''
		end pregunta9,
		enc.comentarios
	from 
		t_encuestas enc
	order by
		enc.almacen,
		enc.usuario,
		enc.id_redencion;
	
	drop table if exists t_redenciones;
	drop table if exists t_encuestas;
	
end //

delimiter ;

call sp_consulta_encuesta_redencion();