
DROP TABLE PARTENECEA;
DROP TABLE ASIGNATURAS;
DROP TABLE PRESTAMOS;
DROP TABLE INSTRUMENTOS;
DROP TABLE PAGOS;
DROP TABLE FALTAS;
DROP TABLE MATRICULA;
DROP TABLE RELACIONES;
DROP TABLE RESPONSABLES;
DROP TABLE USUARIOS;

CREATE TABLE USUARIO
	(
	OID_U NUMBER(3),
	NOMBRE VARCHAR2(50) NOT NULL,
	APELLIDOS VARCHAR2(50) NOT NULL,
	FECHA_NACIMIENTO DATE NOT NULL,
	DIRECCION VARCHAR2(60),
	EMAIL VARCHAR2(60),
	TELEFONO NUMBER(9),
	DERECHOS_DE_IMAGEN BOOLEAN DEFAULT FALSE NOT NULL,
	PRIMARY KEY (OID_U),
	);



CREATE TABLE RESPONSABLE
	(
	OID_R NUMBER(3),
	NOMBRE VARCHAR2(50) NOT NULL,
	APELLIDOS VARCHAR2(50) NOT NULL,
	TELEFONO NUMBER(9),
	EMAIL VARCHAR2(60),
	PRIMARY KEY (OID_R),
	);


CREATE TABLE RELACION
	(
	OID_REL NUMBER(3),
	OID_U NUMBER(3),
	OID_R NUMBER(3),
	TIPO_DE_RELACION VARCHAR2(60),
	PRIMARY KEY (OID_REL),
	FOREIGN KEY (OID_U) REFERENCES USUARIO,
	FOREIGN KEY (OID_R) REFERENCES RESPONSABLE
	);
	

CREATE TABLE MATRICULA
	(
	OID_M NUMBER(3),
	FECHA_DE_MATRICULACION DATE,
	CURSO INT NOT NULL,
	CODIGO INT NOT NULL,
	OID_U NUMBER(3),
	PRIMARY KEY (OID_M),
	FOREIGN KEY (OID_U) REFERENCES USUARIO
	);


CREATE TABLE FALTAS
	(
	OID_F NUMBER(3),
	TIPO_DE_FALTA ENUM('Pago','Asistencia'),
	FECHA_DE_FALTA DATE,
	JUSTIFICADA BOOLEAN DEFAULT FALSE,
	OID_M NUMBER(3),
	PRIMARY KEY (OID_F),
	FOREIGN KEY (OID_M) REFERENCES MATRICULA
	);


CREATE TABLE PAGOS
	(
	OID_Pa NUMBER(3),
	FECHA_DE_PAGO DATE,
	CANTIDAD CHAR(10) NOT NULL,
	CONCEPTO CHAR(10) NOT NULL,
	ESTADO ENUM('Pagado', 'Pendiente'),
	OID_M NUMBER(3),
	PRIMARY KEY (OID_Pa),
	FOREIGN KEY (OID_M) REFERENCES MATRICULA
	);


CREATE TABLE INSTRUMENTO
	(
	OID_I NUMBER(3), 
	TIPO VARCHAR2(50) NOT NULL,
	LIBRE BOOLEAN DEFAULT TRUE,
	NOMBRE VARCHAR2(50),
	ESTADO_DE_INSTRUMENTO ENUM('Nuevo','Usado','Deteriorado'),
	PRIMARY KEY (OID_I)
	);


CREATE TABLE PRESTAMO
	(
	OID_P NUMBER(3), 
	FECHA_DE_PRESTAMO DATE,
	OID_M NUMBER(3),
	OID_I NUMBER(3),
	PRIMARY KEY (OID_P),
	FOREIGN KEY (OID_M) REFERENCES MATRICULA,
	FOREIGN KEY (OID_I) REFERENCES INSTRUMENTO
	);


CREATE TABLE ASIGNATURA
	(
	OID_A NUMBER(3), 
	NOMBRE VARCHAR2(60) NOT NULL,
	PRIMARY KEY (OID_A),
	);


CREATE TABLE PERTENECEA
	(
	OID_PA NUMBER(5),
	OID_M NUMBER(3),
	OID_A NUMBER(3), 
	PRIMARY KEY (OID_PA),
	FOREIGN KEY (OID_M) REFERENCES MATRICULA,
	FOREIGN KEY (OID_A) REFERENCES ASIGNATURA
	);

