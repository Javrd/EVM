DROP TABLE empleados;
CREATE TABLE empleados
  ( cod_emp integer,
  nom_emp varchar2(50) not null, 
  salario number(9,2) DEFAULT 100000, 
  fecha_nac date DEFAULT SYSDATE,
  comision number(5,2), CHECK (comision>=0 AND comision<=1), 
  cod_jefe integer, 
  PRIMARY KEY (cod_emp),
  FOREIGN KEY (cod_jefe) REFERENCES empleados ON DELETE CASCADE);
  
DROP SEQUENCE SEC_EMP;
CREATE SEQUENCE SEC_EMP INCREMENT BY 1 START WITH 1;

CREATE OR REPLACE TRIGGER SECUENCIA_EMPLEADO
BEFORE INSERT ON EMPLEADOS
FOR EACH ROW
BEGIN
SELECT SEC_EMP.NEXTVAL INTO :NEW.cod_emp FROM DUAL;
END;
/
-- Se pone la barra "/" despues de un trigger para poner varios triggers seguidos

CREATE OR REPLACE PROCEDURE contratar_empleado
(w_nom_emp IN empleados.nom_emp%TYPE,
w_salario IN empleados.salario%TYPE,
w_fecha_nac IN empleados.fecha_nac%TYPE,
w_comision IN empleados.comision%TYPE,
w_cod_jefe IN empleados.cod_jefe%TYPE) IS
BEGIN
INSERT INTO empleados (nom_emp,salario,fecha_nac,comision,cod_jefe)
VALUES (w_nom_emp,w_salario,w_fecha_nac, w_comision,w_cod_jefe);
END;
/
CREATE OR REPLACE FUNCTION obtener_salario
(w_cod_emp IN empleados.cod_emp%TYPE)
RETURN NUMBER IS w_salario_bruto empleados.salario%TYPE;
BEGIN
SELECT salario*(1+comision) INTO w_salario_bruto FROM empleados
WHERE cod_emp = w_cod_emp;
RETURN(w_salario_bruto);
END;
/
CREATE OR REPLACE PROCEDURE subordinados AS
CURSOR C IS
SELECT cod_jefe,count(*) AS cuenta FROM empleados
GROUP BY cod_jefe ORDER BY 2 DESC;
BEGIN
FOR fila IN C LOOP
  EXIT WHEN C%ROWCOUNT >3;
  DBMS_OUTPUT.PUT_LINE('Jefe con ID ' || fila.cod_jefe || ' tiene ' || fila.cuenta || ' empleados');
  END LOOP;
END;
/

EXECUTE contratar_empleado('Manuel García',1500,'14/11/1982',0.7,null);
EXECUTE contratar_empleado('Francisco Pérez',1000,'27/05/1976',0.7,null);
EXECUTE contratar_empleado('Francisco Pérez2',1000,'27/05/1976',0.7,null);
EXECUTE contratar_empleado('Francisco Pérez3',1000,'27/05/1976',0.7,1);
EXECUTE contratar_empleado('Francisco Pérez4',1000,'27/05/1976',0.7,1);
EXECUTE contratar_empleado('Francisco Pérez5',1000,'27/05/1976',0.7,2);
EXECUTE contratar_empleado('Francisco Pérez6',1000,'27/05/1976',0.7,3);

EXECUTE subordinados;

--SELECT cod_emp,nom_emp,salario,comision,obtener_salario(cod_emp) FROM empleados;

SET SERVEROUTPUT ON
BEGIN DBMS_OUTPUT.PUT_LINE('Salario de empleado ' || sec_emp.currval || ' : ' ||
obtener_salario(sec_emp.currval));
END;
/




