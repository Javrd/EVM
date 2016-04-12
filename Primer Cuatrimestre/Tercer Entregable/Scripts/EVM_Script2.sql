  /*********************************************************************
                          PROCEDIMIENTOS DE INSERCION
  **********************************************************************/
  
CREATE OR REPLACE PROCEDURE crear_usuario
(nombre2 IN usuarios.nombre%TYPE,
apellidos2 IN usuarios.apellidos%TYPE,
fecha_nacimiento2 IN usuarios.fecha_nacimiento%TYPE,
direccion2 IN usuarios.direccion%TYPE,
email2 IN usuarios.email%TYPE,
telefono2 IN usuarios.telefono%TYPE,
derechos_imagen2 IN usuarios.derechos_imagen%TYPE) IS
BEGIN
INSERT INTO usuarios (nombre,apellidos,fecha_nacimiento,direccion,email,telefono,derechos_imagen)
VALUES (nombre2,apellidos2,fecha_nacimiento2,direccion2,email2,telefono2,derechos_imagen2);
END;
/
CREATE OR REPLACE PROCEDURE crear_responsable
(nombre2 IN responsables.nombre%TYPE,
apellidos2 IN responsables.apellidos%TYPE,
email2 IN responsables.email%TYPE,
telefono2 IN responsables.telefono%TYPE) IS
BEGIN
INSERT INTO responsables (nombre,apellidos,email,telefono)
VALUES (nombre2,apellidos2,email2,telefono2);
END;
/
CREATE OR REPLACE PROCEDURE crear_relacion
(oid_u2 IN relaciones.oid_u%TYPE,
oid_r2 IN relaciones.oid_r%TYPE,
tipo_relacion2 IN relaciones.tipo_relacion%TYPE) IS
BEGIN
INSERT INTO relaciones (oid_u,oid_r,tipo_relacion)
VALUES (oid_u2,oid_r2,tipo_relacion2);
END;
/
CREATE OR REPLACE PROCEDURE crear_matricula
(fecha_matriculacion2 IN matriculas.fecha_matriculacion%TYPE,
curso2 IN matriculas.curso%TYPE,
codigo2 IN matriculas.codigo%TYPE,
oid_u2 IN matriculas.oid_u%TYPE) IS
BEGIN
INSERT INTO matriculas (fecha_matriculacion,curso,codigo,oid_u)
VALUES (fecha_matriculacion2,curso2,codigo2,oid_u2);
END;
/
CREATE OR REPLACE PROCEDURE crear_falta
(tipo_falta2 IN faltas.tipo_falta%TYPE,
fecha_falta2 IN faltas.fecha_falta%TYPE,
justificada2 IN faltas.justificada%TYPE,
oid_m2 IN faltas.oid_m%TYPE) IS
BEGIN
INSERT INTO faltas (tipo_falta,fecha_falta,justificada,oid_m)
VALUES (tipo_falta2,fecha_falta2,justificada2,oid_m2);
END;
/
CREATE OR REPLACE PROCEDURE crear_pago
(fecha_pago2 IN pagos.fecha_pago%TYPE,
cantidad2 IN pagos.cantidad%TYPE,
concepto2 IN pagos.concepto%TYPE,
estado2 IN pagos.estado%TYPE,
oid_m2 IN pagos.oid_m%TYPE) IS
BEGIN
INSERT INTO pagos (fecha_pago,cantidad,concepto,estado,oid_m)
VALUES (fecha_pago2,cantidad2,concepto2,estado2,oid_m2);
END;
/
CREATE OR REPLACE PROCEDURE crear_instrumento
(tipo2 IN instrumentos.tipo%TYPE,
libre2 IN instrumentos.libre%TYPE,
nombre2 IN instrumentos.nombre%TYPE,
estado_instrumento2 IN instrumentos.estado_instrumento%TYPE) IS
BEGIN
INSERT INTO instrumentos (tipo,libre,nombre,estado_instrumento)
VALUES (tipo2,libre2,nombre2,estado_instrumento2);
END;
/
CREATE OR REPLACE PROCEDURE crear_prestamo
(fecha_prestamo2 IN prestamos.fecha_prestamo%TYPE,
oid_m2 IN prestamos.oid_m%TYPE,
oid_i2 IN prestamos.oid_i%TYPE) IS
BEGIN
INSERT INTO prestamos (fecha_prestamo,oid_m,oid_i)
VALUES (fecha_prestamo2,oid_m2,oid_i2);
END;
/
CREATE OR REPLACE PROCEDURE crear_asignatura
(nombre2 IN asignaturas.nombre%TYPE) IS
BEGIN
INSERT INTO asignaturas (nombre)
VALUES (nombre2);
END;
/
CREATE OR REPLACE PROCEDURE crear_pertenece_a
(oid_m2 IN pertenece_a.oid_m%TYPE,
oid_a2 IN pertenece_a.oid_a%TYPE) IS
BEGIN
INSERT INTO pertenece_a (oid_m,oid_a)
VALUES (oid_m2,oid_a2);
END;
/
  /*********************************************************************
                  PROCEDIMIENTOS Y FUNCIONES DE APOYO
  **********************************************************************/
      -- Devuelve el oid de una asignatura a partir de su nombre.
CREATE OR REPLACE FUNCTION buscar_oid_a
(nombre2 asignaturas.nombre%TYPE) RETURN asignaturas.oid_a%TYPE AS
oid_a2 asignaturas.oid_a%TYPE;
BEGIN
SELECT oid_a into oid_a2 from asignaturas where nombre=nombre2;
return oid_a2;
END;
/

    -- Funcion para la comparación de las pruebas.
create or replace FUNCTION ASSERT_EQUALS (salida BOOLEAN, salida_esperada BOOLEAN) RETURN VARCHAR2 AS 
BEGIN
  IF (salida = salida_esperada) THEN
    RETURN 'EXITO';
  ELSE
    RETURN 'FALLO';
  END IF;
END ASSERT_EQUALS;

/
    -- Borra tabla matriculas y sus asociadas.
CREATE OR REPLACE PROCEDURE BORRAR_MATRICULA_CASCADA AS
BEGIN
DELETE FROM PERTENECE_A;
DELETE FROM PRESTAMOS;
DELETE FROM PAGOS;
DELETE FROM FALTAS;
DELETE FROM MATRICULAS;
END BORRAR_MATRICULA_CASCADA;
    
/

    -- Devuelve nombre y apellidos de usuario a partir del oid.
CREATE OR REPLACE FUNCTION nombre_usuario(usuario usuarios.oid_u%type)
RETURN VARCHAR2 AS
    nombre2 usuarios.nombre%type;
    apellidos2 usuarios.apellidos%type;
BEGIN
 SELECT nombre into nombre2 from usuarios where oid_u=usuario;
 SELECT apellidos into apellidos2 from usuarios where oid_u=usuario;
return nombre2 || ' ' || apellidos2;
END;
/
 
   /*********************************************************************
        PROCEDIMIENTOS Y FUNCIONES SOBRE REQUISITOS FUNCIONALES
  **********************************************************************/
  
      -- REQUISITO FUNCIONAL 01

CREATE OR REPLACE PROCEDURE INSTRUMENTOS_LIBRES AS
CURSOR c IS
SELECT oid_i, nombre, estado_instrumento FROM instrumentos where  libre=1;

BEGIN
     DBMS_OUTPUT.PUT_LINE('Instrumentos libres');
  FOR fila IN c LOOP
     DBMS_OUTPUT.PUT_LINE('ID ' || fila.oid_i ||' - '|| fila.nombre ||' - '|| fila.estado_instrumento);
  END LOOP;
END INSTRUMENTOS_LIBRES;
/

    --REQUISITO FUNCIONAL 02

CREATE OR REPLACE PROCEDURE RESPONSABLE_DEL_USUARIO (usuario usuarios.oid_u%type) AS
CURSOR c IS
SELECT OID_R, NOMBRE, APELLIDOS, EMAIL, TELEFONO FROM RESPONSABLES NATURAL JOIN RELACIONES WHERE OID_U=usuario;
BEGIN
    DBMS_OUTPUT.PUT_LINE('Los datos del responsable del usuario ' || nombre_usuario(usuario) || ' son:');
    FOR fila IN c LOOP
     DBMS_OUTPUT.PUT_LINE(fila.oid_r ||' - '|| fila.nombre ||' - '|| fila.APELLIDOS || ' - '|| fila.EMAIL ||' - '|| fila.TELEFONO);
  END LOOP;

END RESPONSABLE_DEL_USUARIO;
/
    --REQUISITO FUNCIONAL 07
CREATE OR REPLACE PROCEDURE MATRICULAS_EN_VIGOR AS
CURSOR c IS
SELECT curso, codigo, oid_u FROM MATRICULAS WHERE FECHA_MATRICULACION>(SYSDATE - 365);
BEGIN
     DBMS_OUTPUT.PUT_LINE('Matriculas en vigor:');
     DBMS_OUTPUT.PUT_LINE('CODIGO - CURSO - ALUMNO');
  FOR fila IN c LOOP
     DBMS_OUTPUT.PUT_LINE(fila.codigo ||' - '|| fila.curso ||' - '|| NOMBRE_USUARIO(fila.oid_u));
  END LOOP;
END MATRICULAS_EN_VIGOR;

/
    --REQUISITO FUNCIONAL 08
CREATE OR REPLACE PROCEDURE MATRICULAS_POR_CURSO AS
CURSOR c IS
SELECT fecha_matriculacion, codigo, curso, oid_u FROM MATRICULAS ORDER BY CURSO;
BEGIN
     DBMS_OUTPUT.PUT_LINE('Matriculas por curso:');
     DBMS_OUTPUT.PUT_LINE('CODIGO - FECHA - CURSO - ALUMNO');
  FOR fila IN c LOOP
     DBMS_OUTPUT.PUT_LINE(fila.codigo ||' - '|| fila.fecha_matriculacion ||' - '|| fila.curso ||' - '|| NOMBRE_USUARIO(fila.oid_u));
  END LOOP;
END MATRICULAS_POR_CURSO;
    
/
    --REQUISITO FUNCIONAL 09

CREATE OR REPLACE PROCEDURE PAGOS_DEL_USUARIO (usuario usuarios.oid_u%type) AS

CURSOR c IS
SELECT FECHA_PAGO, CANTIDAD, CONCEPTO, ESTADO FROM PAGOS NATURAL JOIN MATRICULAS where  oid_u=usuario;

BEGIN
     DBMS_OUTPUT.PUT_LINE('Pagos del usuario '|| nombre_usuario(usuario) || ' (ID ' || usuario || ')');
  FOR fila IN c LOOP
     DBMS_OUTPUT.PUT_LINE(fila.FECHA_PAGO ||' - '|| fila.CANTIDAD ||' - '|| fila.CONCEPTO ||' - '|| fila.ESTADO);
  END LOOP;
END PAGOS_DEL_USUARIO;
/

    --REQUISITO FUNCIONAL 10

CREATE OR REPLACE PROCEDURE USUARIOS_CON_PRESTAMOS AS


CURSOR c IS
SELECT OID_U, FECHA_PRESTAMO FROM PRESTAMOS NATURAL JOIN MATRICULAS NATURAL JOIN USUARIOS;

BEGIN
  FOR fila IN c LOOP
      DBMS_OUTPUT.PUT_LINE('Al usuario '|| nombre_usuario(fila.oid_u) ||
      ' con ID ' || fila.oid_u || ' se le presto un instrumento el ' || fila.fecha_prestamo);
  END LOOP;
END USUARIOS_CON_PRESTAMOS;
/

    --REQUISITO FUNCIONAL 11
CREATE OR REPLACE PROCEDURE ASIGNATURAS_DEL_USUARIO(usuario usuarios.oid_u%type) AS

 CURSOR c IS
 SELECT NOMBRE FROM ASIGNATURAS NATURAL JOIN PERTENECE_A NATURAL JOIN MATRICULAS WHERE OID_U=usuario AND
 FECHA_MATRICULACION>(SYSDATE - 365);
 begin
 
      DBMS_OUTPUT.PUT_LINE('Asignaturas del usuario ' || nombre_usuario(usuario) || ':');
   FOR fila IN c LOOP
      DBMS_OUTPUT.PUT_LINE(fila.nombre);
  END LOOP;
 END ASIGNATURAS_DEL_USUARIO;
 
 /
 
    --REQUISITO FUNCIONAL 12
 CREATE OR REPLACE PROCEDURE FALTAS_DEL_USUARIO(usuario usuarios.oid_u%type) AS

 CURSOR c IS
 SELECT TIPO_FALTA, FECHA_FALTA, JUSTIFICADA FROM FALTAS NATURAL JOIN MATRICULAS WHERE OID_U=usuario AND
 FECHA_MATRICULACION>(SYSDATE - 365);
 begin
 
      DBMS_OUTPUT.PUT_LINE('Faltas del usuario ' || nombre_usuario(usuario) || ':');
   FOR fila IN c LOOP
      DBMS_OUTPUT.PUT_LINE(fila.TIPO_FALTA || ' - ' || fila.FECHA_FALTA || ' - ' || fila.JUSTIFICADA);
  END LOOP;
 END FALTAS_DEL_USUARIO;
 
 /
