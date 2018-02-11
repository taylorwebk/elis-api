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
  dia tinyint,
  ini time,
  fin time,
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
insert into modulo (nombre, dsc) values
('Desarrollo Web con HTML5', 'aprende html5 css3 y Js'),
('Android', 'desarrollo android'),
('Laravel', 'aprende a desarrollar laravel');