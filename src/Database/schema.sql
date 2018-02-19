CREATE DATABASE elisdb DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
use elisdb;
create table persona(
  id integer not null auto_increment,
  nombres varchar(127),
  apellidos varchar(127),
  cel integer,
  primary key(id)
);
create table estudiante(
  id integer not null auto_increment,
  persona_id integer not null,
  correo varchar(127),
  edad tinyint,
  sexo enum('M', 'F'),
  univ varchar(127),
  primary key(id),
  foreign key(persona_id)
  references persona(id)
  on delete cascade
);
create table instructor(
  id integer not null auto_increment,
  persona_id integer not null,
  fb varchar(255),
  ci integer,
  primary key(id), 
  foreign key(persona_id)
  references persona(id)
  on delete cascade
);
create table modulo(
  id integer not null auto_increment,
  nombre varchar(127),
  dsc varchar(256),
  dia varchar(127),
  ini time,
  fin time,
  whatsapp varchar(255),
  requisitos varchar(127),
  primary key(id)
);
create table instructor_modulo(
  instructor_id integer not null,
  modulo_id integer not null,
  primary key(instructor_id, modulo_id),
  foreign key(instructor_id)
  references instructor(id)
  on delete cascade,
  foreign key(modulo_id)
  references modulo(id)
  on delete cascade
);
create table estudiante_modulo(
  estudiante_id integer not null,
  modulo_id integer not null,
  qrurl varchar(127),
  primary key(estudiante_id, modulo_id),
  foreign key(estudiante_id)
  references estudiante(id)
  on delete cascade,
  foreign key(modulo_id)
  references modulo(id)
);
create table asistencia(
  id integer not null auto_increment,
  estudiante_id integer not null,
  modulo_id integer not null,
  fecha date,
  primary key(id),
  foreign key(estudiante_id)
  references estudiante(id)
  on delete cascade,
  foreign key(modulo_id)
  references modulo(id)
  on delete cascade
);
-- android miercoles de 16 a 18
insert into modulo (nombre, dsc, dia, ini, fin, whatsapp, requisitos) values
('Desarrollo Web con HTML5', 'Desarrolla sitios web con HTML5, CSS3 Y JavaScript.', 'Martes', '14:00:00', '16:00:00', 'https://chat.whatsapp.com/3V09T92yFm94pRqnIPnWIH', 'Ninguno'),
('Desarrollo de apps con Android y Kotlin', 'Desarrollo de aplicaciones android con el nuevo lenguaje de programación: Kotlin.', 'Miércoles', '16:00:00', '18:00:00', 'https://chat.whatsapp.com/2n4G5faHlvCHUG2b1LkDzt', 'Ninguno'),
('Curso de Laravel', 'Crea aplicaciones web completas con el framework PHP estrella.', 'Viernes', '10:00:00', '13:00:00', 'https://chat.whatsapp.com/JnKhudw0Mhd6NqO82TvF7M', 'Programación básica en PHP'),
('ReactJS + Redux: El arte de hacer Front-End', 'Aprende a crear sitios totalmente interactivos con ReactJS y Redux', 'Jueves', '14:00:00', '16:00:00', 'https://chat.whatsapp.com/BOnSNRspVZxES8MUrUOX0d', 'Conocimiento medio de JavaScript');