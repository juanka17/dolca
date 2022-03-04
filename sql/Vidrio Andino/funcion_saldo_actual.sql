delimiter //

set @id_usuario = 2;

drop function if exists obtener_saldo_actual//

create function obtener_saldo_actual(id_usuario_par int) returns int
begin

	declare saldo_actual int;
	
	set saldo_actual = (select sum(case when con.suma = 1 then ecu.puntos else ecu.puntos * -1 end ) puntos
	from estado_cuenta ecu inner join conceptos con on con.id = ecu.id_concepto
	where ecu.id_usuario = id_usuario_par);
	
	return saldo_actual;
	
end//

delimiter ;