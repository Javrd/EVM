    -- PROCEDIMIENTO CON CURSOR:

CREATE OR REPLACE PROCEDURE INSTRUMENTOS_LIBRES AS
CURSOR c IS
SELECT * FROM instrumentos where  libre=1;
BEGIN
     DBMS_OUTPUT.PUT_LINE('Instrumentos libres');
  FOR fila IN c LOOP
     DBMS_OUTPUT.PUT_LINE('ID ' || fila.oid_i ||' - '|| fila.nombre);
  END LOOP;
END INSTRUMENTOS_LIBRES;
/

EXECUTE crear_instrumento('Cuerda', 1, 'Violin1', 'Usado');
EXECUTE crear_instrumento('Cuerda', 0, 'Violin2', 'Usado');
EXECUTE crear_instrumento('Cuerda', 0, 'Guitarra1', 'Usado');
EXECUTE crear_instrumento('Cuerda', 1, 'Guitarra2', 'Deteriorado');
SET SERVEROUTPUT ON
EXECUTE instrumentos_libres;

CREATE OR REPLACE PROCEDURE PAGOS_DEL_USUARIO (usuario usuarios.oid_u%type) AS
CURSOR c IS
SELECT OID_PA, FECHA_PAGO, CANTIDAD, CONCEPTO, ESTADO FROM PAGOS NATURAL JOIN MATRICULAS where  oid_u=usuario;
BEGIN
     DBMS_OUTPUT.PUT_LINE('Pagos del usuario con id ' || usuario);
  FOR fila IN c LOOP
     DBMS_OUTPUT.PUT_LINE(fila.oid_pa ||' - '|| fila.FECHA_PAGO ||' - '|| fila.CANTIDAD ||' - '|| fila.CONCEPTO ||' - '|| fila.ESTADO);
  END LOOP;
END PAGOS_DEL_USUARIO;
/

DELETE FROM instrumentos;
EXECUTE crear_instrumento('Cuerda', 1, 'Violin1', 'Usado');
EXECUTE crear_instrumento('Cuerda', 0, 'Violin2', 'Usado');
EXECUTE crear_instrumento('Cuerda', 0, 'Guitarra1', 'Usado');
EXECUTE crear_instrumento('Cuerda', 1, 'Guitarra2', 'Deteriorado');
SET SERVEROUTPUT ON
EXECUTE instrumentos_libres;

DELETE FROM pagos;
DELETE FROM matriculas;
DELETE FROM usuarios;
EXECUTE crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
EXECUTE crear_matricula(to_date('20/09/14','DD/MM/RR'),1,'i101', sec_u.currval);
EXECUTE crear_matricula(to_date('20/09/15','DD/MM/RR'),1,'i201', sec_u.currval);
SET SERVEROUTPUT ON
EXECUTE PAGOS_DEL_USUARIO(sec_u.currval);
