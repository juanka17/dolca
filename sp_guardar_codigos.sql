drop procedure if exists sp_guardar_codigos;

DELIMITER //
s
create procedure sp_guardar_codigos(IN id_registro INT,IN id_participante INT,IN id_bono INT,IN id_registra int)
BEGIN

SET @id_registro = id_registro;
SET @id_participante = id_participante;
SET @id_bono = id_bono;
SET @id_registra = id_registra;

INSERT INTO bonos_solicitados (id_registro,id_participante,id_bono,fecha,id_registra)
VALUES (@id_registro,@id_participante,@id_bono,NOW(),@id_registra);

UPDATE productos_registrados SET estado = 2 WHERE id = @id_registro;

UPDATE bonos SET estado = 1 WHERE id = @id_bono;

SELECT * FROM productos_registrados WHERE id_participante = @id_participante;

end //

delimiter ;

call sp_guardar_codigos(56,8,504,1);
