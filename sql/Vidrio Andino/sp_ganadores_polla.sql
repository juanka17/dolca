drop procedure if exists sp_polla_mundial;

DELIMITER //

create procedure sp_polla_mundial(id_usuario_p int)
begin
	
	set @id_usuario = id_usuario_p;
	
	drop temporary table if exists t_polla;
	create temporary table if not exists t_polla as (
	
		select
			pol.id,
			pol.nombre nombre_polla,
			equ1.id id_equipo_a,
			equ1.nombre nombre_equipo_a,
			equ2.id id_equipo_b,
			equ2.nombre nombre_equipo_b,
			pol.resultado_a,
			pol.resultado_b,
			CASE
				WHEN pol.resultado_a > pol.resultado_b THEN equ1.nombre
				WHEN pol.resultado_b > pol.resultado_a THEN equ2.nombre
				ELSE "Empate"
			END Ganador,
			CASE
				WHEN pol.resultado_a > pol.resultado_b THEN equ1.id 
				WHEN pol.resultado_b > pol.resultado_a THEN equ2.id
				ELSE "9999"
			END id_ganador
		from
			polla pol
			inner join polla_equipos equ1 on equ1.id = pol.id_equipo_a
			inner join polla_equipos equ2 on equ2.id = pol.id_equipo_b
		where
			pol.resultado_a is not null
			and pol.resultado_b is not null
		
		
	);
	
	drop temporary table if exists t_usuarios;
	create temporary table if not exists t_usuarios as (
	
		select
			par.id,
			par.id_polla,
			par.id_usuario,
			usu.nombre nombre_usuario,
			par.marcadora,
			par.marcadorb,
			CASE
				WHEN par.marcadora > par.marcadorb THEN equ1.nombre
				WHEN par.marcadorb > par.marcadora THEN equ2.nombre
				ELSE "Empate"
			END ganador,
			CASE
				WHEN par.marcadora > par.marcadorb THEN equ1.id 
				WHEN par.marcadorb > par.marcadora THEN equ2.id
				ELSE "9999"
			END id_ganador
		from
			polla_participacion par
		inner join usuarios usu on usu.id = par.id_usuario		
		inner join polla pol on pol.id = par.id_polla
		inner join polla_equipos equ1 on equ1.id = pol.id_equipo_a
		inner join polla_equipos equ2 on equ2.id = pol.id_equipo_b
		
		
	);
	
	drop temporary table if exists t_ganadores;
	create temporary table if not exists t_ganadores as (
	
		select
			usr.id_usuario,
			usr.nombre_usuario,
			poll.id polla_id,
			poll.nombre_polla,
			poll.id_equipo_a,
			poll.nombre_equipo_a,
			poll.id_equipo_b,
			poll.nombre_equipo_b,
			poll.resultado_a,
			poll.resultado_b,
			poll.ganador marcador_ganador,
			poll.id_ganador id_marcador_ganador,
			usr.marcadora,
			usr.marcadorb,
			usr.ganador equipo_ganador,
			usr.id_ganador id_equipo_ganador,
			CASE
				WHEN poll.resultado_a = usr.marcadora and poll.resultado_b = usr.marcadorb THEN 3
				ELSE "0"
			END Puntos_resultado,
			CASE
				WHEN poll.id_ganador = usr.id_ganador THEN 3
				ELSE "0"
			END Puntos_equipos
		from
			t_polla poll
		inner join t_usuarios usr on poll.id = usr.id_polla
		
		
	);
	
	drop temporary table if exists t_predicciones;
	create temporary table if not exists t_predicciones as (
	
		select id_usuario,sum(puntos) puntos 
		from polla_resultado_prediccion
		group by id_usuario
	
	);
	
	if(@id_usuario >= 0)then
	
		select 
			gan.id_usuario,
			polla_id,
			nombre_polla,
			sum(puntos_resultado) puntos_resultado,
			sum(puntos_equipos) puntos_equipos,
			sum(puntos_resultado+puntos_equipos) total
		from
			t_ganadores gan
		where 
			gan.id_usuario = @id_usuario 
		group by	
			nombre_polla
		union
			select
				prp.id_usuario,
				prp.id polla_id,
				concat(prp.concepto,' (',prp.aciertos,' aciertos)') nombre_polla,
				prp.puntos puntos_resultado,
				0 puntos_equipos,
				prp.puntos total
			from
				polla_resultado_prediccion prp
			where 
				prp.id_usuario = @id_usuario 
			order by 2;
	else
		select 
			gan.id_usuario,
			nombre_usuario,
			sum(puntos_resultado)puntos_resultado,
			sum(puntos_equipos)puntos_equipos,
			pre.puntos puntos_prediccion,
			sum(puntos_resultado+puntos_equipos) + pre.puntos total	
		from
			t_ganadores	gan	
			inner join t_predicciones pre on pre.id_usuario = gan.id_usuario
		group by	
			gan.id_usuario
		order by 
			total desc;
	end if;
			
end //

delimiter ;

call sp_polla_mundial(-1);