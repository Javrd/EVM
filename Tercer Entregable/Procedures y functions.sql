
 
DELETE FROM prestamos;
DELETE FROM instrumentos;
EXECUTE crear_instrumento('Cuerda', 1, 'Violin', 'Usado');
EXECUTE crear_instrumento('Cuerda', 1, 'Violin', 'Usado');
EXECUTE crear_instrumento('Cuerda', 0, 'Violin', 'Usado');
EXECUTE crear_instrumento('Cuerda', 0, 'Guitarra', 'Usado');
EXECUTE crear_instrumento('Cuerda', 1, 'Guitarra', 'Deteriorado');
SET SERVEROUTPUT ON
EXECUTE instrumentos_libres;

EXECUTE borrar_matricula_cascada;
DELETE FROM usuarios;
EXECUTE crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
EXECUTE crear_matricula(to_date('20/09/14','DD/MM/RR'),1,'i101', sec_u.currval);
EXECUTE crear_matricula(to_date('20/09/15','DD/MM/RR'),1,'i201', sec_u.currval);
SET SERVEROUTPUT ON
EXECUTE PAGOS_DEL_USUARIO(sec_u.currval);

EXECUTE borrar_matricula_cascada;
DELETE FROM instrumentos;
DELETE FROM usuarios;
EXECUTE crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
EXECUTE crear_matricula(to_date('20/09/15','DD/MM/RR'),1,'i101', sec_u.currval);
EXECUTE crear_instrumento('Cuerda', 1, 'Violin', 'Usado');
EXECUTE crear_prestamo(to_date('20/09/15','DD/MM/RR'), sec_m.currval, sec_i.currval);
EXECUTE usuarios_con_prestamos;

EXECUTE borrar_matricula_cascada;
DELETE FROM asignaturas;
DELETE FROM usuarios;
EXECUTE crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
EXECUTE crear_matricula(to_date('20/09/15','DD/MM/RR'),1,'i101', sec_u.currval);
EXECUTE crear_asignatura('asignatura1');
EXECUTE crear_pertenece_a(sec_m.currval, sec_a.currval);
EXECUTE crear_asignatura('asignatura2');
EXECUTE crear_pertenece_a(sec_m.currval, sec_a.currval);
EXECUTE crear_asignatura('asignatura3');
EXECUTE crear_pertenece_a(sec_m.currval, sec_a.currval);
EXECUTE asignaturas_del_usuario(sec_u.currval);

EXECUTE borrar_matricula_cascada;
DELETE FROM asignaturas;
DELETE FROM instrumentos;
DELETE FROM usuarios;
EXECUTE crear_usuario('Julian', 'Perez Muñoz', to_date('15/02/05', 'DD/MM/RR'), 'C\ Ramon y Cajal Nº4', null, null, 1);
EXECUTE crear_matricula(to_date('20/09/15','DD/MM/RR'),1,'i101', sec_u.currval);
EXECUTE crear_falta('Asistencia', to_date('15/11/15', 'DD/MM/RR'),1,sec_m.currval);
EXECUTE crear_falta('Pago', to_date('1/12/15', 'DD/MM/RR'),1,sec_m.currval);
EXECUTE crear_falta('Asistencia', to_date('4/12/15', 'DD/MM/RR'),0,sec_m.currval);
EXECUTE crear_falta('Asistencia', to_date('11/12/15', 'DD/MM/RR'),0,sec_m.currval);
EXECUTE faltas_del_usuario(sec_u.currval);