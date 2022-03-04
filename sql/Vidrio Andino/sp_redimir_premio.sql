drop procedure if exists sp_redimir_premio;

DELIMITER //

create procedure sp_redimir_premio(id_usuario_p int, id_premio_p int, puntos_p int, comentarios_p varchar(100), direccion_envio_p varchar(100), id_registra_p int, ciudad_p varchar(100))
begin

	declare puede_redimir bit;
	declare error varchar(100);

	set @id_concepto = 2;
	set @id_periodo = 0;
	set @id_redencion = 0;
	set @nombre_premio = '';
	set @descripcion_ecu = '';
	set @id_seguimiento_redencion = 0;
	set @id_estado_cuenta = 0;
	set @saldo_actual = 0;
	
	set puede_redimir = 1;
	set error = '';
	
	if id_premio_p in (2073,2095,2386,2387) then
		set puede_redimir = (select verificar_topes_tarjetas(id_usuario_p,id_premio_p));
		set error = 'Se superan los topes de redención.';
	end if;
	
	if id_premio_p in (2407,2408) and comentarios_p = '' then
		set puede_redimir = 0;
		set error = 'Especifique correo y celular en el comentarios.';
	end if;
	
	set @saldo_actual = (select obtener_saldo_actual(id_usuario_p));
	if (@saldo_actual - puntos_p) < 0 then
		set puede_redimir = 0;
		set error = 'Se supera el saldo disponible.';
	end if;

	if puede_redimir then
	
		
		set @id_periodo = (SELECT max(id) FROM periodo WHERE now() between fecha_inicio and fecha_final);
		
		insert into redenciones (id_usuario,id_premio,id_periodo,puntos,comentarios,direccion_envio,id_registra,ciudad_envio) values 
		(id_usuario_p,id_premio_p,@id_periodo,puntos_p,comentarios_p,direccion_envio_p,id_registra_p,ciudad_p);
		
		set @id_redencion = (select LAST_INSERT_ID());
		
		insert into seguimiento_redencion (id_redencion,id_operacion,comentario,fecha,id_registra)
		values (@id_redencion,1,comentarios_p,now(),id_registra_p);
		
		set @id_seguimiento_redencion = (select LAST_INSERT_ID());
		
		set @nombre_premio = (select max(nombre) from premios where id = id_premio_p);
		set @descripcion_ecu = concat('Redencion ',@nombre_premio);
		
		insert into estado_cuenta(id_periodo,id_concepto,id_usuario,puntos,descripcion,fecha)
		values (@id_periodo,@id_concepto,id_usuario_p,puntos_p,@descripcion_ecu,now());
		
		set @id_estado_cuenta = (select LAST_INSERT_ID());
		
		update redenciones set 
			id_ultima_operacion = @id_seguimiento_redencion ,
			id_estado_cuenta = @id_estado_cuenta
		where 
			id = @id_redencion;
		
		call sp_obtener_redencion(@id_redencion);
	  
	else 
	
	  set @nombre_premio = (select max(nombre) from premios where id = id_premio_p);
	  select @nombre_premio premio,error;
	  
	end if;

end//

DELIMITER ;

/*
call sp_redimir_premio(120,2072,4771,'','',899);
*/