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