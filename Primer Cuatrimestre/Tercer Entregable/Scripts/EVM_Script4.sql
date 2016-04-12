 /* PAQUETES */


 CREATE OR REPLACE PACKAGE PRUEBAS_ASIGNATURAS AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_nombre asignaturas.nombre%TYPE,salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2,w_oid_a asignaturas.oid_a%TYPE, w_nombre asignaturas.nombre%TYPE, salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_a asignaturas.oid_a%TYPE, salidaEsperada BOOLEAN);

END PRUEBAS_ASIGNATURAS;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_ASIGNATURAS AS
  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
    DELETE FROM pertenece_a;
    DELETE FROM asignaturas;     
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE ASIGNATURAS */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_nombre asignaturas.nombre%TYPE,salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    asignatura asignaturas%ROWTYPE;
    w_oid_a asignaturas.oid_a%TYPE;
  BEGIN
    
    /* Insertar asignatura */
    CREAR_ASIGNATURA(w_nombre); 
    
    /* Seleccionar asignatura y comprobar que los datos se insertaron correctamente */
    w_oid_a := sec_a.currval;
    SELECT * INTO asignatura FROM asignaturas WHERE oid_a=w_oid_a;
    IF (asignatura.nombre<>w_nombre) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE ASIGNATURAS */
  PROCEDURE actualizar (nombre_prueba VARCHAR2,w_oid_a asignaturas.oid_a%TYPE, w_nombre asignaturas.nombre%TYPE, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    asignatura asignaturas%ROWTYPE;
  BEGIN
    
    /* Actualizar nombre */
    UPDATE asignaturas SET nombre=w_nombre WHERE oid_a=w_oid_a;
    
    /* Seleccionar asignatura y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO asignatura FROM asignaturas WHERE oid_a=w_oid_a;
    IF (asignatura.nombre<>w_nombre) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;


/* PRUEBA PARA LA ELIMINACIÓN DE ASIGNATURAS */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_a asignaturas.oid_a%TYPE, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_asignaturas INTEGER;
  BEGIN
    
    /* Eliminar asignatura */
    DELETE FROM asignaturas WHERE oid_a=w_oid_a;
    
    /* Verificar que el asignatura no se encuentra en la BD */
    SELECT COUNT(*) INTO n_asignaturas FROM asignaturas WHERE oid_a=w_oid_a;
    IF (n_asignaturas <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END PRUEBAS_ASIGNATURAS;

/

CREATE OR REPLACE PACKAGE PRUEBAS_USUARIOS AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_nombre usuarios.nombre%type, w_apellidos usuarios.apellidos%type, 
  w_fecha_nacimiento usuarios.fecha_nacimiento%type, w_direccion usuarios.direccion%type, w_email usuarios.email%type,
  w_telefono usuarios.telefono%type, w_derechos_imagen usuarios.derechos_imagen%type,salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_u usuarios.oid_u%type, w_nombre usuarios.nombre%type, 
  w_apellidos usuarios.apellidos%type, w_fecha_nacimiento usuarios.fecha_nacimiento%type, w_direccion usuarios.direccion%type,
  w_email usuarios.email%type,  w_telefono usuarios.telefono%type, w_derechos_imagen usuarios.derechos_imagen%type, 
  salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_u usuarios.oid_u%type, salidaEsperada BOOLEAN);

END PRUEBAS_USUARIOS;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_USUARIOS AS

  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
     DELETE FROM relaciones;
     borrar_matricula_cascada;
     DELETE FROM usuarios;
     
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE USUARIOS */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_nombre usuarios.nombre%type, w_apellidos usuarios.apellidos%type, 
  w_fecha_nacimiento usuarios.fecha_nacimiento%type, w_direccion usuarios.direccion%type, w_email usuarios.email%type,
  w_telefono usuarios.telefono%type, w_derechos_imagen usuarios.derechos_imagen%type,salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    usuario usuarios%ROWTYPE;
    w_oid_u usuarios.oid_u%type;
  BEGIN
    
    /* Insertar usuario */
    CREAR_USUARIO(w_nombre, w_apellidos,
    w_fecha_nacimiento, w_direccion, w_email, w_telefono, w_derechos_imagen);
    
    /* Seleccionar usuario y comprobar que los datos se insertaron correctamente */
    w_oid_u := sec_u.currval;
    SELECT * INTO usuario FROM usuarios WHERE oid_u=w_oid_u;
    IF (usuario.nombre<>w_nombre OR usuario.apellidos<>w_apellidos OR usuario.fecha_nacimiento<>w_fecha_nacimiento 
    OR usuario.direccion<>w_direccion OR usuario.email<>w_email OR usuario.telefono<>w_telefono 
    OR usuario.derechos_imagen<>w_derechos_imagen) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE USUARIOS */
  PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_u usuarios.oid_u%type, w_nombre usuarios.nombre%type, 
  w_apellidos usuarios.apellidos%type, w_fecha_nacimiento usuarios.fecha_nacimiento%type, w_direccion usuarios.direccion%type,
  w_email usuarios.email%type,  w_telefono usuarios.telefono%type, w_derechos_imagen usuarios.derechos_imagen%type, 
  salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    usuario usuarios%ROWTYPE;
  BEGIN
    
    /* Actualizar usuario */
    UPDATE usuarios SET nombre=w_nombre, apellidos=w_apellidos, fecha_nacimiento=w_fecha_nacimiento, 
    direccion=w_direccion, email=w_email,  telefono=w_telefono, derechos_imagen=w_derechos_imagen WHERE oid_u=w_oid_u;
    
    /* Seleccionar usuario y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO usuario FROM usuarios WHERE oid_u=w_oid_u;
    IF (usuario.nombre<>w_nombre OR usuario.apellidos<>w_apellidos OR usuario.fecha_nacimiento<>w_fecha_nacimiento 
    OR usuario.direccion<>w_direccion OR usuario.email<>w_email OR usuario.telefono<>w_telefono 
    OR usuario.derechos_imagen<>w_derechos_imagen) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;


/* PRUEBA PARA LA ELIMINACIÓN DE USUARIOS */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_u usuarios.oid_u%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_usuarios INTEGER;
  BEGIN
    
    /* Eliminar usuario */
    DELETE FROM usuarios WHERE oid_u=w_oid_u;
    
    /* Verificar que el usuario no se encuentra en la BD */
    SELECT COUNT(*) INTO n_usuarios FROM usuarios WHERE oid_u=w_oid_u;
    IF (n_usuarios <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END PRUEBAS_USUARIOS;
/

CREATE OR REPLACE PACKAGE PRUEBAS_MATRICULAS AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_fecha_matriculacion matriculas.fecha_matriculacion%type,
   w_curso matriculas.curso%type, w_codigo matriculas.codigo%type, w_oid_u matriculas.oid_u%type, salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_m matriculas.oid_m%type, w_fecha_matriculacion matriculas.fecha_matriculacion%type,
   w_curso matriculas.curso%type, w_codigo matriculas.codigo%type, w_oid_u matriculas.oid_u%type, salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_m matriculas.oid_m%type, salidaEsperada BOOLEAN);

END PRUEBAS_MATRICULAS;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_MATRICULAS AS

  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
     borrar_matricula_cascada;
     DELETE FROM relaciones;
     DELETE FROM usuarios;
     crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
     CREAR_ASIGNATURA('Expresion Corporal y Danza'); /* Para que se cumpla un trigger */
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE MATRICULAS */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_fecha_matriculacion matriculas.fecha_matriculacion%type,
   w_curso matriculas.curso%type, w_codigo matriculas.codigo%type, w_oid_u matriculas.oid_u%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    matricula matriculas%ROWTYPE;
    w_oid_m matriculas.oid_m%type;
  BEGIN
    
    /* Insertar matricula */
    CREAR_MATRICULA(w_fecha_matriculacion, w_curso, w_codigo, w_oid_u);
    
    /* Seleccionar matricula y comprobar que los datos se insertaron correctamente */
    w_oid_m := sec_m.currval;
    SELECT * INTO matricula FROM matriculas WHERE oid_m=w_oid_m;
    IF (matricula.fecha_matriculacion<>w_fecha_matriculacion OR matricula.curso<>w_curso 
    OR matricula.codigo<>w_codigo OR matricula.oid_u<>w_oid_u) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE MATRICULAS */
  PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_m matriculas.oid_m%type, w_fecha_matriculacion matriculas.fecha_matriculacion%type,
   w_curso matriculas.curso%type, w_codigo matriculas.codigo%type, w_oid_u matriculas.oid_u%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    matricula matriculas%ROWTYPE;
  BEGIN
    
    /* Actualizar matricula */
    UPDATE matriculas SET fecha_matriculacion=w_fecha_matriculacion, curso=w_curso, codigo=w_codigo, oid_u=w_oid_u WHERE oid_m=w_oid_m;
    
    /* Seleccionar matricula y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO matricula FROM matriculas WHERE oid_m=w_oid_m;
    IF (matricula.fecha_matriculacion<>w_fecha_matriculacion OR matricula.curso<>w_curso 
    OR matricula.codigo<>w_codigo OR matricula.oid_u<>w_oid_u) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;

/* PRUEBA PARA LA ELIMINACIÓN DE MATRICULAS */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_m matriculas.oid_m%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_matriculas INTEGER;
  BEGIN
    
    /* Eliminar matricula */
    DELETE FROM pagos WHERE oid_m=w_oid_m;
    DELETE FROM matriculas WHERE oid_m=w_oid_m;
    
    /* Verificar que la matricula no se encuentra en la BD */
    SELECT COUNT(*) INTO n_matriculas FROM matriculas WHERE oid_m=w_oid_m;
    IF (n_matriculas <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END PRUEBAS_MATRICULAS;
/

CREATE OR REPLACE PACKAGE PRUEBAS_FALTAS AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_tipo_falta faltas.tipo_falta%type, 
  w_fecha_falta faltas.fecha_falta%type, w_justificada faltas.justificada%type, w_oid_m faltas.oid_m%type, salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_f faltas.oid_f%type, w_tipo_falta faltas.tipo_falta%type, 
  w_fecha_falta faltas.fecha_falta%type, w_justificada faltas.justificada%type, w_oid_m faltas.oid_m%type, salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_f faltas.oid_f%type, salidaEsperada BOOLEAN);

END PRUEBAS_FALTAS;
/
 CREATE OR REPLACE PACKAGE BODY PRUEBAS_FALTAS AS

  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
    
     borrar_matricula_cascada;
     DELETE FROM relaciones;
     DELETE FROM usuarios;
     crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
     crear_matricula(to_date('20/09/14','DD/MM/RR'),1,'i101',sec_u.currval);
     
     
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE FALTAS */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_tipo_falta faltas.tipo_falta%type, 
  w_fecha_falta faltas.fecha_falta%type, w_justificada faltas.justificada%type,
  w_oid_m faltas.oid_m%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    falta faltas%ROWTYPE;
    w_oid_f faltas.oid_f%type;
  BEGIN
    
    /* Insertar falta */
    CREAR_FALTA(w_tipo_falta, w_fecha_falta, w_justificada, w_oid_m);
    
    /* Seleccionar falta y comprobar que los datos se insertaron correctamente */
    w_oid_f := sec_f.currval;
    SELECT * INTO falta FROM faltas WHERE oid_f=w_oid_f;
    IF (falta.tipo_falta<>w_tipo_falta OR falta.fecha_falta<>w_fecha_falta OR falta.justificada<>w_justificada 
    OR falta.oid_m<>w_oid_m) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE FALTAS */
  PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_f faltas.oid_f%type, w_tipo_falta faltas.tipo_falta%type, 
  w_fecha_falta faltas.fecha_falta%type, w_justificada faltas.justificada%type, w_oid_m faltas.oid_m%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    falta faltas%ROWTYPE;
  BEGIN
    
    /* Actualizar empleado */
    UPDATE faltas SET oid_f=w_oid_f, tipo_falta=w_tipo_falta, 
  fecha_falta=w_fecha_falta, justificada=w_justificada, oid_m=w_oid_m WHERE oid_f=w_oid_f;
    
    /* Seleccionar falta y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO falta FROM faltas WHERE oid_f=w_oid_f;
    IF (falta.tipo_falta<>w_tipo_falta OR falta.fecha_falta<>w_fecha_falta OR falta.justificada<>w_justificada 
    OR falta.oid_m<>w_oid_m) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;


/* PRUEBA PARA LA ELIMINACIÓN DE FALTAS */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_f faltas.oid_f%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_faltas INTEGER;
  BEGIN
    
    /* Eliminar falta */
    DELETE FROM faltas WHERE oid_f=w_oid_f;
    
    /* Verificar que el falta no se encuentra en la BD */
    SELECT COUNT(*) INTO n_faltas FROM faltas WHERE oid_f=w_oid_f;
    IF (n_faltas <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END PRUEBAS_FALTAS;
/

CREATE OR REPLACE PACKAGE PRUEBAS_INSTRUMENTOS AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_tipo instrumentos.tipo%type, w_libre instrumentos.libre%type, 
   w_nombre instrumentos.nombre%type, w_estado_instrumento instrumentos.estado_instrumento%type, salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_i instrumentos.oid_i%type, w_tipo instrumentos.tipo%type, w_libre instrumentos.libre%type, 
   w_nombre instrumentos.nombre%type, w_estado_instrumento instrumentos.estado_instrumento%type, salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_i instrumentos.oid_i%type, salidaEsperada BOOLEAN);

END PRUEBAS_INSTRUMENTOS;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_INSTRUMENTOS AS

  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
     DELETE FROM prestamos;
     DELETE FROM instrumentos;
     
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE INSTRUMENTOS */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_tipo instrumentos.tipo%type, w_libre instrumentos.libre%type, 
   w_nombre instrumentos.nombre%type, w_estado_instrumento instrumentos.estado_instrumento%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    instrumento instrumentos%ROWTYPE;
    w_oid_i instrumentos.oid_i%type;
  BEGIN
    
    /* Insertar instrumento */
    CREAR_INSTRUMENTO(w_tipo, w_libre, w_nombre, w_estado_instrumento);
    
    /* Seleccionar instrumento y comprobar que los datos se insertaron correctamente */
    w_oid_i := sec_i.currval;
    SELECT * INTO instrumento FROM instrumentos WHERE oid_i=w_oid_i;
    IF (instrumento.tipo<>w_tipo OR instrumento.libre<>w_libre 
    OR instrumento.nombre<>w_nombre OR instrumento.estado_instrumento<>w_estado_instrumento) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE INSTRUMENTOS */
  PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_i instrumentos.oid_i%type, w_tipo instrumentos.tipo%type, w_libre instrumentos.libre%type, 
   w_nombre instrumentos.nombre%type, w_estado_instrumento instrumentos.estado_instrumento%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    instrumento instrumentos%ROWTYPE;
  BEGIN
    
    /* Actualizar instrumento */
    UPDATE instrumentos SET tipo=w_tipo, libre=w_libre, nombre=w_nombre, estado_instrumento=w_estado_instrumento WHERE oid_i=w_oid_i;
    
    /* Seleccionar instrumento y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO instrumento FROM instrumentos WHERE oid_i=w_oid_i;
    IF (instrumento.tipo<>w_tipo OR instrumento.libre<>w_libre 
    OR instrumento.nombre<>w_nombre OR instrumento.estado_instrumento<>w_estado_instrumento) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;


/* PRUEBA PARA LA ELIMINACIÓN DE INSTRUMENTOS */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_i instrumentos.oid_i%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_instrumentos INTEGER;
  BEGIN
    
    /* Eliminar instrumento */
    DELETE FROM instrumentos WHERE oid_i=w_oid_i;
    
    /* Verificar que la instrumento no se encuentra en la BD */
    SELECT COUNT(*) INTO n_instrumentos FROM instrumentos WHERE oid_i=w_oid_i;
    IF (n_instrumentos <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END PRUEBAS_INSTRUMENTOS;
/

CREATE OR REPLACE PACKAGE PRUEBAS_PERTENECE_A AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_oid_m pertenece_a.oid_m%type, w_oid_a pertenece_a.oid_a%type, salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_pe pertenece_a.oid_pe%type, w_oid_m pertenece_a.oid_m%type,
   w_oid_a pertenece_a.oid_a%type, salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_pe pertenece_a.oid_pe%type, salidaEsperada BOOLEAN);

END PRUEBAS_PERTENECE_A;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_PERTENECE_A AS

  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
    
     borrar_matricula_cascada;
     DELETE FROM asignaturas;
     DELETE FROM relaciones;
     DELETE FROM usuarios;
     crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
     crear_matricula(to_date('20/09/14','DD/MM/RR'),1,'i101',sec_u.currval);
     crear_asignatura('Expresión Corporal y Danza');
     
     
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE PERTENECE_A */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_oid_m pertenece_a.oid_m%type, w_oid_a pertenece_a.oid_a%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    w_pertenece_a pertenece_a%ROWTYPE;
    w_oid_pe pertenece_a.oid_pe%type;
  BEGIN
    
    /* Insertar pertenece_a */
    CREAR_PERTENECE_A(w_oid_m, w_oid_a);
    
    /* Seleccionar pertenece_a y comprobar que los datos se insertaron correctamente */
    w_oid_pe := sec_pe.currval;
    SELECT * INTO w_pertenece_a FROM pertenece_a WHERE oid_pe=w_oid_pe;
    IF (w_pertenece_a.oid_m<>w_oid_m OR w_pertenece_a.oid_a<>w_oid_a) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE PERTENECE_A */
  PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_pe pertenece_a.oid_pe%type, w_oid_m pertenece_a.oid_m%type,
   w_oid_a pertenece_a.oid_a%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    w_pertenece_a pertenece_a%ROWTYPE;
  BEGIN
    
    /* Actualizar pertenece_a */
    UPDATE pertenece_a SET oid_m=w_oid_m, oid_a=w_oid_a WHERE oid_pe=w_oid_pe;
    
    /* Seleccionar pertenece_a y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO w_pertenece_a FROM pertenece_a WHERE oid_pe=w_oid_pe;
    IF (w_pertenece_a.oid_m<>w_oid_m OR w_pertenece_a.oid_a<>w_oid_a) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;


/* PRUEBA PARA LA ELIMINACIÓN DE PERTENECE_A */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_pe pertenece_a.oid_pe%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_pertenece_a INTEGER;
  BEGIN
    
    /* Eliminar pertenece_a */
    DELETE FROM pertenece_a WHERE oid_pe=w_oid_pe;
    
    /* Verificar que la relacion pertenece_a no se encuentra en la BD */
    SELECT COUNT(*) INTO n_pertenece_a FROM pertenece_a WHERE oid_pe=w_oid_pe;
    IF (n_pertenece_a <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END PRUEBAS_PERTENECE_A;
/

CREATE OR REPLACE PACKAGE PRUEBAS_PRESTAMOS AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_fecha_prestamo prestamos.fecha_prestamo%type, w_oid_m prestamos.oid_m%type,
   w_oid_i prestamos.oid_i%type, salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_p prestamos.oid_p%type, w_fecha_prestamo prestamos.fecha_prestamo%type, 
   w_oid_m prestamos.oid_m%type, w_oid_i prestamos.oid_i%type, salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_p prestamos.oid_p%type, salidaEsperada BOOLEAN);

END PRUEBAS_PRESTAMOS;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_PRESTAMOS AS

  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
     borrar_matricula_cascada;
     DELETE FROM instrumentos;
     DELETE FROM prestamos;
     crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
     crear_matricula(to_date('20/09/14','DD/MM/RR'),1,'i101',sec_u.currval);
     crear_instrumento('Cuerda', 1, 'Violin', 'Usado');
     
     
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE PRESTAMOS */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_fecha_prestamo prestamos.fecha_prestamo%type, w_oid_m prestamos.oid_m%type,
   w_oid_i prestamos.oid_i%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    prestamo prestamos%ROWTYPE;
    w_oid_p prestamos.oid_p%type;
  BEGIN
    
    /* Insertar prestamos */
    CREAR_PRESTAMO(w_fecha_prestamo, w_oid_m, w_oid_i);
    
    /* Seleccionar prestamos y comprobar que los datos se insertaron correctamente */
    w_oid_p := sec_p.currval;
    SELECT * INTO prestamo FROM prestamos WHERE oid_p=w_oid_p;
    IF (prestamo.fecha_prestamo<>w_fecha_prestamo OR prestamo.oid_m<>w_oid_m OR prestamo.oid_i<>w_oid_i) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE PRESTAMOS */
  PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_p prestamos.oid_p%type, w_fecha_prestamo prestamos.fecha_prestamo%type, 
   w_oid_m prestamos.oid_m%type, w_oid_i prestamos.oid_i%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    prestamo prestamos%ROWTYPE;
  BEGIN
    
    /* Actualizar prestamos */
    UPDATE prestamos SET fecha_prestamo=w_fecha_prestamo, oid_m=w_oid_m, oid_i=w_oid_i WHERE oid_p=w_oid_p;
    
    /* Seleccionar prestamos y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO prestamo FROM prestamos WHERE oid_p=w_oid_p;
    IF (prestamo.fecha_prestamo<>w_fecha_prestamo OR prestamo.oid_m<>w_oid_m OR prestamo.oid_i<>w_oid_i) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;


/* PRUEBA PARA LA ELIMINACIÓN DE PRESTAMOS */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_p prestamos.oid_p%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_prestamos INTEGER;
  BEGIN
    
    /* Eliminar prestamos */
    DELETE FROM prestamos WHERE oid_p=w_oid_p;
    
    /* Verificar que la relacion prestamos no se encuentra en la BD */
    SELECT COUNT(*) INTO n_prestamos FROM prestamos WHERE oid_p=w_oid_p;
    IF (n_prestamos <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END PRUEBAS_PRESTAMOS;
/

CREATE OR REPLACE PACKAGE PRUEBAS_RESPONSABLES AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_nombre responsables.nombre%type, w_apellidos responsables.apellidos%type, 
  w_email responsables.email%type, w_telefono responsables.telefono%type, salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_r responsables.oid_r%type, w_nombre responsables.nombre%type, 
  w_apellidos responsables.apellidos%type, w_email responsables.email%type,  w_telefono responsables.telefono%type, salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_r responsables.oid_r%type, salidaEsperada BOOLEAN);

END PRUEBAS_RESPONSABLES;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_RESPONSABLES AS

  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
     DELETE FROM relaciones;
     DELETE FROM responsables;
     
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE RESPONSABLES */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_nombre responsables.nombre%type, w_apellidos responsables.apellidos%type, 
  w_email responsables.email%type, w_telefono responsables.telefono%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    responsable responsables%ROWTYPE;
    w_oid_r responsables.oid_r%type;
  BEGIN
    
    /* Insertar responsable */
    CREAR_RESPONSABLE(w_nombre, w_apellidos, w_email, w_telefono);
    
    /* Seleccionar responsable y comprobar que los datos se insertaron correctamente */
    w_oid_r := sec_r.currval;
    SELECT * INTO responsable FROM responsables WHERE oid_r=w_oid_r;
    IF (responsable.nombre<>w_nombre OR responsable.apellidos<>w_apellidos OR responsable.email<>w_email 
    OR responsable.telefono<>w_telefono) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE RESPONSABLES */
  PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_r responsables.oid_r%type, w_nombre responsables.nombre%type, 
  w_apellidos responsables.apellidos%type, w_email responsables.email%type,  w_telefono responsables.telefono%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    responsable responsables%ROWTYPE;
  BEGIN
    
    /* Actualizar responsable */
    UPDATE responsables SET nombre=w_nombre, apellidos=w_apellidos, email=w_email, telefono=w_telefono WHERE oid_r=w_oid_r;
    
    /* Seleccionar responsable y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO responsable FROM responsables WHERE oid_r=w_oid_r;
    IF (responsable.nombre<>w_nombre OR responsable.apellidos<>w_apellidos OR responsable.email<>w_email 
    OR responsable.telefono<>w_telefono) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;


/* PRUEBA PARA LA ELIMINACIÓN DE RESPONSABLES */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_r responsables.oid_r%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_responsables INTEGER;
  BEGIN
    
    /* Eliminar responsable */
    DELETE FROM responsables WHERE oid_r=w_oid_r;
    
    /* Verificar que el responsable no se encuentra en la BD */
    SELECT COUNT(*) INTO n_responsables FROM responsables WHERE oid_r=w_oid_r;
    IF (n_responsables <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END PRUEBAS_RESPONSABLES;
/

CREATE OR REPLACE PACKAGE PRUEBAS_PAGOS AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_fecha_pago pagos.fecha_pago%type, w_cantidad pagos.cantidad%type, 
   w_concepto pagos.concepto%type, w_estado pagos.estado%type, w_oid_m pagos.oid_m%type, salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_pa pagos.oid_pa%type, w_fecha_pago pagos.fecha_pago%type,
   w_cantidad pagos.cantidad%type, w_concepto pagos.concepto%type, w_estado pagos.estado%type, w_oid_m pagos.oid_m%type, 
   salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_pa pagos.oid_pa%type, salidaEsperada BOOLEAN);

END PRUEBAS_PAGOS;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_PAGOS AS

  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
     borrar_matricula_cascada;
     DELETE FROM relaciones;
     DELETE FROM usuarios;
     crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
     crear_matricula(to_date('20/09/14','DD/MM/RR'),1,'i101',sec_u.currval);
        
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE PAGOS */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_fecha_pago pagos.fecha_pago%type, w_cantidad pagos.cantidad%type,
  w_concepto pagos.concepto%type, w_estado pagos.estado%type, w_oid_m pagos.oid_m%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    pago pagos%ROWTYPE;
    w_oid_pa pagos.oid_pa%type;
  BEGIN
    
    /* Insertar pago */
    CREAR_PAGO(w_fecha_pago, w_cantidad, w_concepto, w_estado, w_oid_m);
    
    /* Seleccionar pago y comprobar que los datos se insertaron correctamente */
    w_oid_pa := sec_pa.currval;
    SELECT * INTO pago FROM pagos WHERE oid_pa=w_oid_pa;
    IF (pago.fecha_pago<>w_fecha_pago OR pago.cantidad<>w_cantidad 
    OR pago.concepto<>w_concepto OR pago.estado<>w_estado OR pago.oid_m<>w_oid_m) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE PAGOS */
  PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_pa pagos.oid_pa%type, w_fecha_pago pagos.fecha_pago%type,
   w_cantidad pagos.cantidad%type, w_concepto pagos.concepto%type, w_estado pagos.estado%type, w_oid_m pagos.oid_m%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    pago pagos%ROWTYPE;
  BEGIN
    
    /* Actualizar pago */
    UPDATE pagos SET fecha_pago=w_fecha_pago, cantidad=w_cantidad, concepto=w_concepto, estado=w_estado, oid_m=w_oid_m WHERE oid_pa=w_oid_pa;
    
    /* Seleccionar pago y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO pago FROM pagos WHERE oid_pa=w_oid_pa;
    IF (pago.fecha_pago<>w_fecha_pago OR pago.cantidad<>w_cantidad 
    OR pago.concepto<>w_concepto OR pago.estado<>w_estado OR pago.oid_m<>w_oid_m) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;


/* PRUEBA PARA LA ELIMINACIÓN DE PAGOS */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_pa pagos.oid_pa%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_pagos INTEGER;
  BEGIN
    
    /* Eliminar pago */
    DELETE FROM pagos WHERE oid_pa=w_oid_pa;
    
    /* Verificar que la pago no se encuentra en la BD */
    SELECT COUNT(*) INTO n_pagos FROM pagos WHERE oid_pa=w_oid_pa;
    IF (n_pagos <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END;
/

CREATE OR REPLACE PACKAGE PRUEBAS_RELACIONES AS 

   PROCEDURE inicializar;
   PROCEDURE insertar (nombre_prueba VARCHAR2, w_oid_u relaciones.oid_u%type, w_oid_r relaciones.oid_r%type, 
   w_tipo_relacion relaciones.tipo_relacion%type, salidaEsperada BOOLEAN);
   PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_rel relaciones.oid_rel%type, w_oid_u relaciones.oid_u%type,
   w_oid_r relaciones.oid_r%type, w_tipo_relacion relaciones.tipo_relacion%type, salidaEsperada BOOLEAN);
   PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_rel relaciones.oid_rel%type, salidaEsperada BOOLEAN);

END PRUEBAS_RELACIONES;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_RELACIONES AS

  /* INICIALIZACIÓN */
  PROCEDURE inicializar AS
  BEGIN

    /* Borrar contenido de la tabla */
     DELETE FROM relaciones;
     borrar_matricula_cascada;
     DELETE FROM usuarios;
     DELETE FROM responsables;
     crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
     crear_responsable('Antonio', 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421');
           
  END inicializar;

/* PRUEBA PARA LA INSERCIÓN DE RELACIONES */
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_oid_u relaciones.oid_u%type, w_oid_r relaciones.oid_r%type,
  w_tipo_relacion relaciones.tipo_relacion%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    relacion relaciones%ROWTYPE;
    w_oid_rel relaciones.oid_rel%type;
  BEGIN
    
    /* Insertar relacion */
    CREAR_RELACION(w_oid_u, w_oid_r, w_tipo_relacion);
    
    /* Seleccionar relacion y comprobar que los datos se insertaron correctamente */
    w_oid_rel := sec_rel.currval;
    SELECT * INTO relacion FROM relaciones WHERE oid_rel=w_oid_rel;
    IF (relacion.oid_u<>w_oid_u OR relacion.oid_r<>w_oid_r 
    OR relacion.tipo_relacion<>w_tipo_relacion) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END insertar;

/* PRUEBA PARA LA ACTUALIZACIÓN DE RELACIONES */
  PROCEDURE actualizar (nombre_prueba VARCHAR2, w_oid_rel relaciones.oid_rel%type, w_oid_u relaciones.oid_u%type,
   w_oid_r relaciones.oid_r%type, w_tipo_relacion relaciones.tipo_relacion%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    relacion relaciones%ROWTYPE;
  BEGIN
    
    /* Actualizar relacion */
    UPDATE relaciones SET oid_u=w_oid_u, oid_r=w_oid_r, tipo_relacion=w_tipo_relacion WHERE oid_rel=w_oid_rel;
    
    /* Seleccionar relacion y comprobar que los campos se actualizaron correctamente */
    SELECT * INTO relacion FROM relaciones WHERE oid_rel=w_oid_rel;
    IF (relacion.oid_u<>w_oid_u OR relacion.oid_r<>w_oid_r 
    OR relacion.tipo_relacion<>w_tipo_relacion) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END actualizar;


/* PRUEBA PARA LA ELIMINACIÓN DE RELACIONES */
  PROCEDURE eliminar (nombre_prueba VARCHAR2,w_oid_rel relaciones.oid_rel%type, salidaEsperada BOOLEAN) AS
    salida BOOLEAN := true;
    n_relaciones INTEGER;
  BEGIN
    
    /* Eliminar relacion */
    DELETE FROM relaciones WHERE oid_rel=w_oid_rel;
    
    /* Verificar que la relacion no se encuentra en la BD */
    SELECT COUNT(*) INTO n_relaciones FROM relaciones WHERE oid_rel=w_oid_rel;
    IF (n_relaciones <> 0) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
    /* Mostrar resultado de la prueba */
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
          ROLLBACK;
  END eliminar;

END PRUEBAS_RELACIONES;
/

CREATE OR REPLACE PACKAGE PRUEBAS_REQUISITOS_FUNCIONALES AS 

   PROCEDURE RF1;
   PROCEDURE RF2;
   PROCEDURE RF7;
   PROCEDURE RF8;
   PROCEDURE RF9;
   PROCEDURE RF10;
   PROCEDURE RF11;
   PROCEDURE RF12;

END PRUEBAS_REQUISITOS_FUNCIONALES;
/

 CREATE OR REPLACE PACKAGE BODY PRUEBAS_REQUISITOS_FUNCIONALES AS

  PROCEDURE RF1 AS
  BEGIN
     
      DELETE FROM prestamos;
      DELETE FROM instrumentos;
      crear_instrumento('Cuerda', 1, 'Violin', 'Usado');
      crear_instrumento('Cuerda', 1, 'Violin', 'Usado');
      crear_instrumento('Cuerda', 0, 'Violin', 'Usado');
      crear_instrumento('Cuerda', 0, 'Guitarra', 'Usado');
      crear_instrumento('Cuerda', 1, 'Guitarra', 'Deteriorado');
      DBMS_OUTPUT.put_line('Prueba de INSTRUMENTOS_LIBRES:');
      DBMS_OUTPUT.put_line('*********************************************************');
      instrumentos_libres;
      DBMS_OUTPUT.put_line('*********************************************************');
           
  END RF1;

  PROCEDURE RF2 AS
  BEGIN
       borrar_matricula_cascada;
       DELETE FROM relaciones;
       DELETE FROM usuarios;
       DELETE FROM responsables;
      crear_responsable('Antonio', 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421');
      crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
      crear_relacion(sec_u.currval, sec_r.currval, 'Padre');
      DBMS_OUTPUT.put_line('Prueba de RESPONSABLE_DEL_USUARIO:');
      DBMS_OUTPUT.put_line('*********************************************************');
      RESPONSABLE_DEL_USUARIO(sec_u.currval);
      DBMS_OUTPUT.put_line('*********************************************************');
           
  END RF2;

  PROCEDURE RF7 AS
  BEGIN
     
      borrar_matricula_cascada;       
      DELETE FROM relaciones;
      DELETE FROM usuarios;
      crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);     
      crear_matricula(to_date('20/09/13','DD/MM/RR'),1,'i101',sec_u.currval);
      crear_matricula(to_date('20/09/14','DD/MM/RR'),2,'i201',sec_u.currval);
      crear_matricula(to_date('20/09/15','DD/MM/RR'),3,'i301',sec_u.currval);
      DBMS_OUTPUT.put_line('Prueba de MATRICULAS_EN_VIGOR:');
      DBMS_OUTPUT.put_line('*********************************************************');
      MATRICULAS_EN_VIGOR;
      DBMS_OUTPUT.put_line('*********************************************************');
           
  END RF7;

  PROCEDURE RF8 AS
  BEGIN
     
      borrar_matricula_cascada;       
      DELETE FROM relaciones;
      DELETE FROM usuarios;
      crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
      crear_matricula(to_date('20/09/13','DD/MM/RR'),1,'i101',sec_u.currval);
      crear_matricula(to_date('20/09/14','DD/MM/RR'),2,'i201',sec_u.currval);
      crear_matricula(to_date('20/09/15','DD/MM/RR'),3,'i301',sec_u.currval);
      DBMS_OUTPUT.put_line('Prueba de MATRICULAS_POR_CURSO:');
      DBMS_OUTPUT.put_line('*********************************************************');
      MATRICULAS_POR_CURSO;
      DBMS_OUTPUT.put_line('*********************************************************');

           
  END RF8;

  PROCEDURE RF9 AS
  BEGIN
     
      borrar_matricula_cascada;
      DELETE FROM relaciones;
      DELETE FROM usuarios;
      crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
      crear_matricula(to_date('20/09/14','DD/MM/RR'),1,'i101', sec_u.currval);
      crear_matricula(to_date('20/09/15','DD/MM/RR'),1,'i201', sec_u.currval);
      DBMS_OUTPUT.put_line('Prueba de PAGOS_DEL_USUARIO:');
      DBMS_OUTPUT.put_line('*********************************************************');
      PAGOS_DEL_USUARIO(sec_u.currval);
      DBMS_OUTPUT.put_line('*********************************************************');
           
  END RF9;

  PROCEDURE RF10 AS
  BEGIN
     
      borrar_matricula_cascada;
      DELETE FROM instrumentos;
      DELETE FROM usuarios;
      crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
      crear_matricula(to_date('20/09/15','DD/MM/RR'),1,'i101', sec_u.currval);
      crear_instrumento('Cuerda', 1, 'Violin', 'Usado');
      crear_prestamo(to_date('20/09/15','DD/MM/RR'), sec_m.currval, sec_i.currval);
      DBMS_OUTPUT.put_line('Prueba de USUARIOS_CON_PRESTAMOS:');
      DBMS_OUTPUT.put_line('*********************************************************');
      usuarios_con_prestamos;
      DBMS_OUTPUT.put_line('*********************************************************');
           
  END RF10;

  PROCEDURE RF11 AS
  BEGIN
     
      borrar_matricula_cascada;
      DELETE FROM asignaturas;
      DELETE FROM usuarios;
      crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
      crear_matricula(to_date('20/09/15','DD/MM/RR'),1,'i101', sec_u.currval);
      crear_asignatura('asignatura1');
      crear_pertenece_a(sec_m.currval, sec_a.currval);
      crear_asignatura('asignatura2');
      crear_pertenece_a(sec_m.currval, sec_a.currval);
      crear_asignatura('asignatura3');
      crear_pertenece_a(sec_m.currval, sec_a.currval);
      DBMS_OUTPUT.put_line('Prueba de ASIGNATURAS_DEL_USUARIO:');
      DBMS_OUTPUT.put_line('*********************************************************');
      asignaturas_del_usuario(sec_u.currval);
      DBMS_OUTPUT.put_line('*********************************************************');
           
  END RF11;

  PROCEDURE RF12 AS
  BEGIN
     
      borrar_matricula_cascada;
      DELETE FROM asignaturas;
      DELETE FROM instrumentos;
      DELETE FROM usuarios;
      crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
      crear_matricula(to_date('20/09/15','DD/MM/RR'),1,'i101', sec_u.currval);
      crear_falta('Asistencia', to_date('15/11/15', 'DD/MM/RR'),1,sec_m.currval);
      crear_falta('Pago', to_date('1/12/15', 'DD/MM/RR'),1,sec_m.currval);
      crear_falta('Asistencia', to_date('4/12/15', 'DD/MM/RR'),0,sec_m.currval);
      crear_falta('Asistencia', to_date('11/12/15', 'DD/MM/RR'),0,sec_m.currval);
      DBMS_OUTPUT.put_line('Prueba de FALTAS_DEL_USUARIO:');
      DBMS_OUTPUT.put_line('*********************************************************');
      faltas_del_usuario(sec_u.currval);
      DBMS_OUTPUT.put_line('*********************************************************');
           
  END RF12;

END PRUEBAS_REQUISITOS_FUNCIONALES;
/
/* Activar salida de texto por pantalla */
SET SERVEROUTPUT ON;

DECLARE
  oid_u usuarios.oid_u%type;
  oid_r responsables.oid_r%type;
  oid_rel relaciones.oid_rel%type;
  oid_m matriculas.oid_m%type;
  oid_f faltas.oid_f%type;
  oid_pa pagos.oid_pa%type;
  oid_i instrumentos.oid_i%type;
  oid_i2 instrumentos.oid_i%type;
  oid_p prestamos.oid_p%type;
  oid_a asignaturas.oid_a%type;
  oid_pe pertenece_a.oid_pe%type;
BEGIN

  /*********************************************************************
        PRUEBAS DE LAS OPERACIONES SOBRE LAS TABLAS
  **********************************************************************/
  
    PRUEBAS_REQUISITOS_FUNCIONALES.RF1;
    PRUEBAS_REQUISITOS_FUNCIONALES.RF2;
    PRUEBAS_REQUISITOS_FUNCIONALES.RF7;
    PRUEBAS_REQUISITOS_FUNCIONALES.RF8;
    PRUEBAS_REQUISITOS_FUNCIONALES.RF9;
    PRUEBAS_REQUISITOS_FUNCIONALES.RF10;
    PRUEBAS_REQUISITOS_FUNCIONALES.RF11;
    PRUEBAS_REQUISITOS_FUNCIONALES.RF12;
    
      /* Usuarios */
  
  PRUEBAS_USUARIOS.INICIALIZAR;
  PRUEBAS_USUARIOS.INSERTAR('Prueba 1 - Inserción usuario','Julian', 'Perez Muñoz', to_date('15/02/12', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, true);
  oid_u := sec_u.currval;
  PRUEBAS_USUARIOS.INSERTAR('Prueba 2 - Inserción usuario menor a 3 años','Julian', 'Perez Muñoz', to_date('15/02/15', 'dd/mm/rr'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 3 - Inserción usuario con nombre null', null, 'Perez Muñoz', to_date('15/02/11', 'dd/mm/rr'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 4 - Inserción usuario con apellidos null','Julian', null, to_date('15/02/11', 'dd/mm/rr'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 5 - Inserción usuario con fecha de nacimiento null','Julian', 'Perez Muñoz', null, 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 6 - Inserción usuario con direccion null','Julian', 'Perez Muñoz', to_date('15/02/11', 'dd/mm/rr'), null, null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 7 - Inserción usuario con derechos de imagen null','Julian', 'Perez Muñoz', to_date('15/02/11', 'dd/mm/rr'), 'C\ Ramon y Cajal Nº4', null, null, null, false);
  PRUEBAS_USUARIOS.ACTUALIZAR('Prueba 8 - Actualización nombre usuario', oid_u, 'Julio', 'Perez Muñoz', to_date('15/02/11', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, true);
  PRUEBAS_USUARIOS.ACTUALIZAR('Prueba 9 - Actualización nombre usuario null', oid_u, null, 'Perez Muñoz', to_date('15/02/11', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.ACTUALIZAR('Prueba 10 - Actualización edad mayor a 3 años', oid_u, 'Julio', 'Perez Muñoz', to_date('15/02/07', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, true);
  PRUEBAS_USUARIOS.ACTUALIZAR('Prueba 11 - Actualización edad menor a 3 años', oid_u, 'Julio', 'Perez Muñoz', to_date('15/02/15', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);  
  PRUEBAS_USUARIOS.ELIMINAR('Prueba 12 - Eliminación usuario', oid_u, true);

        /* Responsables */
        
  PRUEBAS_RESPONSABLES.INICIALIZAR;   
  PRUEBAS_RESPONSABLES.INSERTAR('Prueba 13 - Inserción responsable','Antonio', 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421', true);
  oid_r := sec_r.currval;
  PRUEBAS_RESPONSABLES.INSERTAR('Prueba 14 - Inserción responsable con nombre a null',null, 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421', false);
  PRUEBAS_RESPONSABLES.INSERTAR('Prueba 15 - Inserción responsable con telefono a null','Antonio', 'Perez Sanchez', 'AntPezSan4@gmail.com', null, false); 
  PRUEBAS_RESPONSABLES.ACTUALIZAR('Prueba 16 - Actualización nombre responsable', oid_r, 'Juan', 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421', true);
  PRUEBAS_RESPONSABLES.ACTUALIZAR('Prueba 17 - Actualización responsable con nombre a null', oid_r, null, 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421', false);
  PRUEBAS_RESPONSABLES.ACTUALIZAR('Prueba 18 - Actualización responsable con telefono a null', oid_r,'Antonio', 'Perez Sanchez', 'AntPezSan4@gmail.com', null, false);
  PRUEBAS_RESPONSABLES.ELIMINAR('Prueba 19 - Eliminación responsable', oid_r, true);

        /* Relaciones */
        
  PRUEBAS_RELACIONES.INICIALIZAR;  
  oid_u := sec_u.currval;
  oid_r := sec_r.currval;
  PRUEBAS_RELACIONES.INSERTAR('Prueba 20 - Inserción relación', oid_u, oid_r, 'Padre', true);
  oid_rel := sec_rel.currval;
  PRUEBAS_RELACIONES.INSERTAR('Prueba 21 - Inserción relación con tipo null',  oid_u, oid_r, null, false);  
  PRUEBAS_RELACIONES.ACTUALIZAR('Prueba 22 - Actualización relación',oid_rel, oid_u, oid_r, 'Tio', true);
  PRUEBAS_RELACIONES.ACTUALIZAR('Prueba 23 - Actualización relación con tipo null', oid_rel, oid_u, oid_r, null, false);  
  PRUEBAS_RELACIONES.ELIMINAR('Prueba 24 - Eliminación relacion', oid_rel, true);

       /* Matriculas */
            
  PRUEBAS_MATRICULAS.INICIALIZAR;  
  oid_u := sec_u.currval;
  PRUEBAS_MATRICULAS.INSERTAR('Prueba 25 - Inserción matrícula', to_date('20/09/14','DD/MM/RR'),1,'i101',oid_u, true);
  oid_m := sec_m.currval;
  PRUEBAS_MATRICULAS.INSERTAR('Prueba 26 - Inserción matrícula con codigo null', to_date('20/09/14','DD/MM/RR'),1,null,oid_u, false);  
  PRUEBAS_MATRICULAS.ACTUALIZAR('Prueba 27 - Actualización fecha matrícula', oid_m, to_date('21/09/14','DD/MM/RR'),1,'i101',oid_u, true);
  PRUEBAS_MATRICULAS.ACTUALIZAR('Prueba 28 - Actualización matrícula con codigo null', oid_m, to_date('20/09/14','DD/MM/RR'),1,null,oid_u, false);
  PRUEBAS_MATRICULAS.ELIMINAR('Prueba 29 - Eliminación matricula', oid_m, true);

              /* Faltas */
              
  PRUEBAS_FALTAS.INICIALIZAR;
  oid_m := sec_m.currval;
  PRUEBAS_FALTAS.INSERTAR('Prueba 30 - Inserción falta','Asistencia', to_date('03/04/15', 'dd/mm/rr'), 0, oid_m, true);
  oid_f := sec_f.currval;
  PRUEBAS_FALTAS.INSERTAR('Prueba 31 - Inserción falta de tipo no enumerado','Modales', to_date('03/04/15', 'dd/mm/rr'), 0, oid_m, false);
  PRUEBAS_FALTAS.ACTUALIZAR('Prueba 32 - Actualización justificacion falta', oid_f,'Asistencia', to_date('03/04/15', 'dd/mm/rr'), 1, oid_m, true);
  PRUEBAS_FALTAS.ACTUALIZAR('Prueba 33 - Actualización falta con tipo no enumerado', oid_f,'Modales', to_date('03/04/15', 'dd/mm/rr'), 1, oid_m, false);
  PRUEBAS_FALTAS.ELIMINAR('Prueba 34 - Eliminación falta', oid_f, true);

                /* Pagos */
                
  PRUEBAS_PAGOS.INICIALIZAR;
  oid_m := sec_m.currval;
  PRUEBAS_PAGOS.INSERTAR('Prueba 35 - Inserción pago', to_date('20/09/14','DD/MM/RR'), 25, 'Matricula', 'Pagado', oid_m, true);
  oid_pa := sec_pa.currval;
  PRUEBAS_PAGOS.INSERTAR('Prueba 36 - Inserción pago con cantidad null', to_date('20/09/14','DD/MM/RR'), null, 'Matricula', 'Pagado', oid_m, false);
  PRUEBAS_PAGOS.INSERTAR('Prueba 37 - Inserción pago con concepto null', to_date('20/09/14','DD/MM/RR'), 25, null, 'Pagado', oid_m, false);
  PRUEBAS_PAGOS.INSERTAR('Prueba 38 - Inserción pago con estado no enumerado', to_date('20/09/14','DD/MM/RR'), 25, 'Matricula', 'Perdonado', oid_m, false);
  PRUEBAS_PAGOS.ACTUALIZAR('Prueba 39 - Actualización cantidad pago', oid_pa, to_date('20/09/14','DD/MM/RR'), 20, 'Matricula', 'Pagado', oid_m, true);
  PRUEBAS_PAGOS.ACTUALIZAR('Prueba 40 - Actualización pago con cantidad null', oid_pa, to_date('20/09/14','DD/MM/RR'), null, 'Matricula', 'Pagado', oid_m, false);
  PRUEBAS_PAGOS.ACTUALIZAR('Prueba 41 - Actualización pago con concepto null', oid_pa, to_date('20/09/14','DD/MM/RR'), 25, null, 'Pagado', oid_m, false);
  PRUEBAS_PAGOS.ACTUALIZAR('Prueba 42 - Actualización pago con estado no enumerado', oid_pa, to_date('20/09/14','DD/MM/RR'), 25, 'Matricula', 'Perdonado', oid_m, false);
  PRUEBAS_PAGOS.ELIMINAR('Prueba 43 - Eliminación pago', oid_pa, true);
               
                /* Instrumentos */
                
  PRUEBAS_INSTRUMENTOS.INICIALIZAR;
  PRUEBAS_INSTRUMENTOS.INSERTAR('Prueba 44 - Inserción instrumento', 'Cuerda', 1, 'Violin', 'Usado', true);
  oid_i := sec_i.currval;
  PRUEBAS_INSTRUMENTOS.INSERTAR('Prueba 45 - Inserción instrumento prestado', 'Cuerda', 0, 'Guitarra', 'Deteriorado', true);
  PRUEBAS_INSTRUMENTOS.INSERTAR('Prueba 46 - Inserción instrumento de tipo no enumerado', 'Cuerda', 1, 'Violin', 'Mojado', false);
  PRUEBAS_INSTRUMENTOS.ACTUALIZAR('Prueba 47 - Actualización instrumento libre', oid_i, 'Cuerda', 1, 'Violin', 'Usado', true);
  PRUEBAS_INSTRUMENTOS.ACTUALIZAR('Prueba 48 - Actualización estado instrumento', oid_i, 'Cuerda', 1, 'Violin', 'Deteriorado', true);
  PRUEBAS_INSTRUMENTOS.ACTUALIZAR('Prueba 49 - Actualización estado instrumento de tipo no enumerado', oid_i, 'Cuerda', 1, 'Violin', 'Mojado', false);
  PRUEBAS_INSTRUMENTOS.ELIMINAR('Prueba 50 - Eliminación instrumento', oid_i, true);
  
               /* Prestamos */
  
  PRUEBAS_PRESTAMOS.INICIALIZAR;
  oid_m := sec_m.currval;
  oid_i := sec_i.currval;
  crear_instrumento('Cuerda', 0, 'Violin', 'Usado');
  oid_i2 := sec_i.currval;
  PRUEBAS_PRESTAMOS.INSERTAR('Prueba 51 - Inserción prestamo', to_date('03/04/15', 'dd/mm/rr'), oid_m, oid_i,true);
  oid_p := sec_p.currval;
  PRUEBAS_PRESTAMOS.INSERTAR('Prueba 52 - Inserción prestamo de un instrumento que no esta libre', to_date('03/04/15', 'dd/mm/rr'), oid_m, oid_i2,false);
  PRUEBAS_PRESTAMOS.ACTUALIZAR('Prueba 53 - Actualización de la fecha de prestamo de un instrumento que no esta libre', oid_p, to_date('04/04/15', 'dd/mm/rr'), oid_m, oid_i,false);
  PRUEBAS_PRESTAMOS.ACTUALIZAR('Prueba 54 - Actualización prestamo de un instrumento que no esta libre', oid_p, to_date('03/04/15', 'dd/mm/rr'), oid_m, oid_i2,false);
  PRUEBAS_PRESTAMOS.ELIMINAR('Prueba 55 - Eliminación prestamo', oid_p, true);

                 /* Asignaturas */
                 
  PRUEBAS_ASIGNATURAS.INICIALIZAR;
  PRUEBAS_ASIGNATURAS.INSERTAR('Prueba 56 - Inserción asignatura','Expresión corporal y danza', true);  
  oid_a := sec_a.currval;    
  PRUEBAS_ASIGNATURAS.INSERTAR('Prueba 57 - Inserción asignatura con nombre null',null, false);
  PRUEBAS_ASIGNATURAS.ACTUALIZAR('Prueba 58 - Actualización nombre asignatura', oid_a, 'Lenguaje musical', true);
  PRUEBAS_ASIGNATURAS.ACTUALIZAR('Prueba 59 - Actualización asignatura con nombre null', oid_a, null, false); 
  PRUEBAS_ASIGNATURAS.ELIMINAR('Prueba 60 - Eliminación asignatura', oid_a, true);         


                /* Pertenece_A */
                
  PRUEBAS_PERTENECE_A.INICIALIZAR;
  oid_m := sec_m.currval;
  oid_a := sec_a.currval;
  PRUEBAS_PERTENECE_A.INSERTAR('Prueba 61 - Inserción pertenece a', oid_m, oid_a, true);
  oid_pe := sec_pe.currval;
  PRUEBAS_PERTENECE_A.ACTUALIZAR('Prueba 62 - Actualización pertenece a con oid asignatura a null', oid_pe, null, oid_a, true);
  PRUEBAS_PERTENECE_A.ELIMINAR('Prueba 63 - Eliminación pertenece_a', oid_pe, true);  
  
END;
  