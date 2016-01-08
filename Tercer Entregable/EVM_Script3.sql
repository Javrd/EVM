CREATE OR REPLACE TRIGGER EDAD_USUARIOS 
BEFORE INSERT OR UPDATE ON USUARIOS 
FOR EACH ROW
BEGIN
IF (SYSDATE-:NEW.FECHA_NACIMIENTO<1100)
THEN raise_application_error(-20501,'Un usuario debe tener al menos 3 anos');
END IF;
END;
/
CREATE OR REPLACE TRIGGER ASIGNATURAS_MENORES
AFTER INSERT ON MATRICULAS
FOR EACH ROW
BEGIN
IF(SYSDATE-:NEW.FECHA_NACIMIENTO>1100 AND SYSDATE-:NEW.FECHA_NACIMIENTO<2200)
THEN CREAR_PERTENECE_A(:new.oid_m,buscar_oid_a('Expresion Corporal y Danza'));
END IF;
END;
/

CREATE OR REPLACE TRIGGER FACTURACION
AFTER INSERT ON MATRICULAS 
FOR EACH ROW
BEGIN
    CREAR_PAGO(null, 25, 'Matricula', 'Pendiente', :NEW.oid_m);
    CREAR_PAGO( null, 35, 'Octubre', 'Pendiente', :NEW.oid_m);
    CREAR_PAGO(null, 35, 'Noviembre', 'Pendiente', :NEW.oid_m);
    CREAR_PAGO(null, 35, 'Diciembre', 'Pendiente', :NEW.oid_m);
    CREAR_PAGO(null, 35, 'Enero', 'Pendiente', :NEW.oid_m);
    CREAR_PAGO(null, 35, 'Febrero', 'Pendiente', :NEW.oid_m);
    CREAR_PAGO(null, 35, 'Marzo', 'Pendiente', :NEW.oid_m);
    CREAR_PAGO(null, 35, 'Abril', 'Pendiente', :NEW.oid_m);
    CREAR_PAGO(null, 35, 'Mayo', 'Pendiente', :NEW.oid_m);
    CREAR_PAGO(null, 35, 'Junio', 'Pendiente', :NEW.oid_m);
    
END;
/


CREATE OR REPLACE TRIGGER ERROR_INSTRUMENTO_PRESTADO
BEFORE INSERT OR UPDATE ON PRESTAMOS 
FOR EACH ROW
DECLARE
inst_libre instrumentos.libre%type;
BEGIN
SELECT libre INTO inst_libre FROM instrumentos WHERE oid_i=:NEW.oid_i;
IF (inst_libre<>1)
THEN raise_application_error(-20502,'El instrumento ya esta prestado');
END IF;
END;
/

CREATE OR REPLACE TRIGGER INSTRUMENTO_PRESTADO
AFTER INSERT OR UPDATE ON PRESTAMOS 
FOR EACH ROW
BEGIN
UPDATE instrumentos SET libre = 0 WHERE oid_i=:NEW.oid_i;
END;
/