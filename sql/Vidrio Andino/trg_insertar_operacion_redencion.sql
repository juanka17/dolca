DELIMITER $$
CREATE TRIGGER trg_insertar_operacion_redencion 
    AFTER INSERT ON seguimiento_redencion
    FOR EACH ROW 
BEGIN
    UPDATE redenciones
    SET id_ultima_operacion = NEW.id
    WHERE id = new.id_redencion;
END$$
DELIMITER ;