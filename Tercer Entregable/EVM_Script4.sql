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
    DELETE FROM asignaturas;     
    /* CREAR_ASIGNATURA('Expresion Corporal y Danza'); */
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
     DELETE FROM matriculas;
     
    
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
     DELETE FROM faltas;
     
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
     DELETE FROM pertenece_a;
     
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
     DELETE FROM prestamos;
     
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
     DELETE FROM pagos;
        
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
  
  /* INICIALIZACIÓN */
  
  PRUEBAS_PERTENECE_A.INICIALIZAR;
  PRUEBAS_ASIGNATURAS.INICIALIZAR;
  PRUEBAS_PRESTAMOS.INICIALIZAR;
  PRUEBAS_INSTRUMENTOS.INICIALIZAR;
  PRUEBAS_PAGOS.INICIALIZAR;
  PRUEBAS_FALTAS.INICIALIZAR;
  PRUEBAS_MATRICULAS.INICIALIZAR;
  PRUEBAS_RELACIONES.INICIALIZAR;
  PRUEBAS_RESPONSABLES.INICIALIZAR;
  PRUEBAS_USUARIOS.INICIALIZAR;
  
  /* INSERCIÓN */
  
      /* Usuarios */
  PRUEBAS_USUARIOS.INSERTAR('Prueba 1 - Inserción usuario','Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, true);  
  oid_u := sec_u.currval;
  PRUEBAS_USUARIOS.INSERTAR('Prueba 2 - Inserción usuario menor a 3 años','Julian', 'Perez Muñoz', to_date('15/02/15', 'dd/mm/rr'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 3 - Inserción usuario con nombre null', null, 'Perez Muñoz', to_date('15/02/11', 'dd/mm/rr'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 4 - Inserción usuario con apellidos null','Julian', null, to_date('15/02/11', 'dd/mm/rr'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 5 - Inserción usuario con fecha de nacimiento null','Julian', 'Perez Muñoz', null, 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 6 - Inserción usuario con direccion null','Julian', 'Perez Muñoz', to_date('15/02/11', 'dd/mm/rr'), null, null, null, 1, false);
  PRUEBAS_USUARIOS.INSERTAR('Prueba 7 - Inserción usuario con derechos de imagen null','Julian', 'Perez Muñoz', to_date('15/02/11', 'dd/mm/rr'), 'C\ Ramon y Cajal Nº4', null, null, null, false);
 
        /* Responsables */
  PRUEBAS_RESPONSABLES.INSERTAR('Prueba 8 - Inserción responsable','Antonio', 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421', true);
  oid_r := sec_r.currval;
  PRUEBAS_RESPONSABLES.INSERTAR('Prueba 9 - Inserción responsable con nombre a null',null, 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421', false);
  PRUEBAS_RESPONSABLES.INSERTAR('Prueba 10 - Inserción responsable con telefono a null','Antonio', 'Perez Sanchez', 'AntPezSan4@gmail.com', null, false);
  
          /* Relaciones */
  PRUEBAS_RELACIONES.INSERTAR('Prueba 11 - Inserción relación', oid_u, oid_r, 'Padre', true);
  oid_rel := sec_rel.currval;
  PRUEBAS_RELACIONES.INSERTAR('Prueba 12 - Inserción relación con tipo null',  oid_u, oid_r, null, false);
  
          /* Matriculas */
  PRUEBAS_MATRICULAS.INSERTAR('Prueba 13 - Inserción matrícula', to_date('20/09/14','DD/MM/RR'),1,'i101',oid_u, true);
  oid_m := sec_m.currval;
  PRUEBAS_MATRICULAS.INSERTAR('Prueba 14 - Inserción matrícula con codigo null', to_date('20/09/14','DD/MM/RR'),1,null,oid_u, false);

            /* Faltas */
  PRUEBAS_FALTAS.INSERTAR('Prueba 15 - Inserción falta','Asistencia', to_date('03/04/15', 'dd/mm/rr'), 0, oid_m, true);
  oid_f := sec_f.currval;
  PRUEBAS_FALTAS.INSERTAR('Prueba 16 - Inserción falta de tipo no enumerado','Modales', to_date('03/04/15', 'dd/mm/rr'), 0, oid_m, false);

              /* Pagos */
  PRUEBAS_PAGOS.INSERTAR('Prueba 17 - Inserción pago', to_date('20/09/14','DD/MM/RR'), 25, 'Matricula', 'Pagado', oid_m, true);
  oid_pa := sec_pa.currval;
  PRUEBAS_PAGOS.INSERTAR('Prueba 18 - Inserción pago con cantidad null', to_date('20/09/14','DD/MM/RR'), null, 'Matricula', 'Pagado', oid_m, false);
  PRUEBAS_PAGOS.INSERTAR('Prueba 19 - Inserción pago con concepto null', to_date('20/09/14','DD/MM/RR'), 25, null, 'Pagado', oid_m, false);
  PRUEBAS_PAGOS.INSERTAR('Prueba 20 - Inserción pago con estado no enumerado', to_date('20/09/14','DD/MM/RR'), 25, 'Matricula', 'Perdonado', oid_m, false);

              /* Instrumentos */
  PRUEBAS_INSTRUMENTOS.INSERTAR('Prueba 21 - Inserción instrumento', 'Cuerda', 1, 'Violin', 'Usado', true);
  oid_i := sec_i.currval;
  PRUEBAS_INSTRUMENTOS.INSERTAR('Prueba 22 - Inserción instrumento prestado', 'Cuerda', 0, 'Guitarra', 'Deteriorado', true);
  oid_i2 := sec_i.currval;
  PRUEBAS_INSTRUMENTOS.INSERTAR('Prueba 23 - Inserción instrumento de tipo no enumerado', 'Cuerda', 1, 'Violin', 'Mojado', false);
  
              /* Prestamos */
  PRUEBAS_PRESTAMOS.INSERTAR('Prueba 24 - Inserción prestamo', to_date('03/04/15', 'dd/mm/rr'), oid_m, oid_i,true);
  oid_p := sec_p.currval;
  PRUEBAS_PRESTAMOS.INSERTAR('Prueba 25 - Inserción prestamo de un instrumento que no esta libre', to_date('03/04/15', 'dd/mm/rr'), oid_m, oid_i2,false);
  
              /* Asignaturas */
  PRUEBAS_ASIGNATURAS.INSERTAR('Prueba 26 - Inserción asignatura','Expresión corporal y danza', true);  
  oid_a := sec_a.currval;
  PRUEBAS_ASIGNATURAS.INSERTAR('Prueba 27 - Inserción asignatura con nombre null',null, false);
  
              /* Pertenece_A */
  PRUEBAS_PERTENECE_A.INSERTAR('Prueba 28 - Inserción pertenece a', oid_m, oid_a, true);
  oid_pe := sec_pe.currval;

    /* ACTUALIZACIÓN */
    
          /* Usuarios */
  PRUEBAS_USUARIOS.ACTUALIZAR('Prueba 29 - Actualización nombre usuario', oid_u, 'Julio', 'Perez Muñoz', to_date('15/02/11', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, true);
  PRUEBAS_USUARIOS.ACTUALIZAR('Prueba 30 - Actualización nombre usuario null', oid_u, null, 'Perez Muñoz', to_date('15/02/11', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  PRUEBAS_USUARIOS.ACTUALIZAR('Prueba 31 - Actualización edad mayor a 3 años', oid_u, 'Julio', 'Perez Muñoz', to_date('15/02/07', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, true);
  PRUEBAS_USUARIOS.ACTUALIZAR('Prueba 32 - Actualización edad menor a 3 años', oid_u, 'Julio', 'Perez Muñoz', to_date('15/02/15', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1, false);
  
 
        /* Responsables */
  PRUEBAS_RESPONSABLES.ACTUALIZAR('Prueba 33 - Actualización nombre responsable', oid_r, 'Juan', 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421', true);
  PRUEBAS_RESPONSABLES.ACTUALIZAR('Prueba 34 - Actualización responsable con nombre a null', oid_r, null, 'Perez Sanchez', 'AntPezSan4@gmail.com', '555643421', false);
  PRUEBAS_RESPONSABLES.ACTUALIZAR('Prueba 35 - Actualización responsable con telefono a null', oid_r,'Antonio', 'Perez Sanchez', 'AntPezSan4@gmail.com', null, false);
  
          /* Relaciones */
  PRUEBAS_RELACIONES.ACTUALIZAR('Prueba 36 - Actualización relación',oid_rel, oid_u, oid_r, 'Tio', true);
  PRUEBAS_RELACIONES.ACTUALIZAR('Prueba 37 - Actualización relación con tipo null', oid_rel, oid_u, oid_r, null, false);
  
          /* Matriculas */
  PRUEBAS_MATRICULAS.ACTUALIZAR('Prueba 38 - Actualización fecha matrícula', oid_m, to_date('21/09/14','DD/MM/RR'),1,'i101',oid_u, true);
  PRUEBAS_MATRICULAS.ACTUALIZAR('Prueba 39 - Actualización matrícula con codigo null', oid_m, to_date('20/09/14','DD/MM/RR'),1,null,oid_u, false);
  
            /* Faltas */
  PRUEBAS_FALTAS.ACTUALIZAR('Prueba 40 - Actualización justificacion falta', oid_f,'Asistencia', to_date('03/04/15', 'dd/mm/rr'), 1, oid_m, true);
  PRUEBAS_FALTAS.ACTUALIZAR('Prueba 41 - Actualización falta con tipo no enumerado', oid_f,'Modales', to_date('03/04/15', 'dd/mm/rr'), 1, oid_m, false);

            /* Pagos */
  PRUEBAS_PAGOS.ACTUALIZAR('Prueba 42 - Actualización cantidad pago', oid_pa, to_date('20/09/14','DD/MM/RR'), 20, 'Matricula', 'Pagado', oid_m, true);
  PRUEBAS_PAGOS.ACTUALIZAR('Prueba 43 - Actualización pago con cantidad null', oid_pa, to_date('20/09/14','DD/MM/RR'), null, 'Matricula', 'Pagado', oid_m, false);
  PRUEBAS_PAGOS.ACTUALIZAR('Prueba 44 - Actualización pago con concepto null', oid_pa, to_date('20/09/14','DD/MM/RR'), 25, null, 'Pagado', oid_m, false);
  PRUEBAS_PAGOS.ACTUALIZAR('Prueba 45 - Actualización pago con estado no enumerado', oid_pa, to_date('20/09/14','DD/MM/RR'), 25, 'Matricula', 'Perdonado', oid_m, false);

            /* Instrumentos */
  PRUEBAS_INSTRUMENTOS.ACTUALIZAR('Prueba 46 - Actualización instrumento libre', oid_i, 'Cuerda', 1, 'Violin', 'Usado', true);
  PRUEBAS_INSTRUMENTOS.ACTUALIZAR('Prueba 47 - Actualización estado instrumento', oid_i, 'Cuerda', 1, 'Violin', 'Deteriorado', true);
  PRUEBAS_INSTRUMENTOS.ACTUALIZAR('Prueba 48 - Actualización estado instrumento de tipo no enumerado', oid_i, 'Cuerda', 1, 'Violin', 'Mojado', false);
  
  
            /* Prestamos */
  PRUEBAS_PRESTAMOS.ACTUALIZAR('Prueba 49 - Actualización fecha prestamo', oid_p, to_date('04/04/15', 'dd/mm/rr'), oid_m, oid_i,true);
  PRUEBAS_PRESTAMOS.ACTUALIZAR('Prueba 50 - Actualización prestamo de un instrumento que no esta libre', oid_p, to_date('03/04/15', 'dd/mm/rr'), oid_m, oid_i2,false);
  
            /* Asignaturas */
  PRUEBAS_ASIGNATURAS.ACTUALIZAR('Prueba 51 - Actualización nombre asignatura', oid_a, 'Lenguaje musical', true);
  PRUEBAS_ASIGNATURAS.ACTUALIZAR('Prueba 52 - Actualización asignatura con nombre null', oid_a, null, false);
  
    /* ELIMINACIÓN */
  PRUEBAS_PERTENECE_A.ELIMINAR('Prueba 53 - Eliminación pertenece_a', oid_pe, true);
  PRUEBAS_ASIGNATURAS.ELIMINAR('Prueba 54 - Eliminación asignatura', oid_a, true);
  PRUEBAS_PRESTAMOS.ELIMINAR('Prueba 55 - Eliminación prestamo', oid_p, true);
  PRUEBAS_INSTRUMENTOS.ELIMINAR('Prueba 56 - Eliminación instrumento', oid_i, true);
  PRUEBAS_PAGOS.ELIMINAR('Prueba 57 - Eliminación pago', oid_pa, true);
  PRUEBAS_FALTAS.ELIMINAR('Prueba 58 - Eliminación falta', oid_f, true);
  PRUEBAS_MATRICULAS.ELIMINAR('Prueba 59 - Eliminación matricula', oid_m, true);
  PRUEBAS_RELACIONES.ELIMINAR('Prueba 60 - Eliminación relacion', oid_rel, true);
  PRUEBAS_RESPONSABLES.ELIMINAR('Prueba 61 - Eliminación responsable', oid_r, true);
  PRUEBAS_USUARIOS.ELIMINAR('Prueba 62 - Eliminación usuario', oid_u, true);


END;
  