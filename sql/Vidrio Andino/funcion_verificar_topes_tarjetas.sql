delimiter //

set @id_usuario = 2;

drop function if exists verificar_topes_tarjetas//

create function verificar_topes_tarjetas(id_usuario_par int, id_premio_par int) returns int
begin

	declare puede_redimir bit;
	declare maximo_periodo bigint;
	
	declare valor_monetario_premio bigint;
	declare tiene_tarjeta bigint;
	
	declare periodo_actual int;
	declare recargas_actuales bigint;
	
	set puede_redimir = 1;
	set maximo_periodo = 300000;
	
	set tiene_tarjeta = (select count(distinct id) from redenciones where id_premio in (2386) and id_usuario = id_usuario_par);
	set valor_monetario_premio = (select max(valor_monetario) from premios where id = id_premio_par);
	
	set periodo_actual = (select max(id) from periodo where now() between fecha_inicio and fecha_final);
	set recargas_actuales = (
		select sum(pre.valor_monetario) 
		from redenciones red inner join premios pre on pre.id = red.id_premio
		where 
			red.id_periodo = periodo_actual 
			and red.id_usuario = id_usuario_par
			and pre.id in (2073,2095,2386,2387)
	);	
	
	/*Verificacion tarjeta*/
	if id_premio_par in (2386) and tiene_tarjeta > 0 then
		set puede_redimir = 0;
	end if;
	
	/*Verificacion topes*/
	/*
	if ifnull((recargas_actuales + valor_monetario_premio),0) > maximo_periodo then
		set puede_redimir = 0;
	end if;
	*/
	
	return puede_redimir;
	
end//

delimiter ;

select verificar_topes_tarjetas(120,2102) topes;