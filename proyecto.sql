show databases;
 
 create schema RUBLE_FORGOTAPP_PROYECT;
 
 use RUBLE_FORGOTAPP_PROYECT;
 
 show tables;
 
 create table Usuarios (
 Id varchar (100) not null,
 Nombre_usuario varchar(60) not null,
 Correo varchar(50) not null,
 Contraseña varchar(50) not null,
 Cumpleaños date not null,
 Telefono varchar (50) not null,
 N° varchar (100) not null,
 
 primary key (Id)
 );
 
 drop table Usuarios;

  select * from Usuarios;

 

 
 create table Categorias (
 N° varchar (100) not null,
 Nombre varchar(60) not null,
 
 primary key (N°)
 );
 
 select * from Categorias;
 
 
 select * from Categorias, Usuarios
where Categorias.N°=Usuarios.N°;

 insert into Usuarios
 (Id, Nombre_usuario, correo, Contraseña, Cumpleaños, Telefono, N°) values
 ('7891', 'maria sanches', '@weeen', 'otgyhj44', '1976-10-25', '3456744', '7');
 
 update Usuarios
 set PLATA='60000'
 where Usuarios.id='7891';
 
update Usuarios
 set edad='47'
 where Usuarios.id='7891';
 
select count(*) from Usuarios;

select count(*) from Usuarios
where Nombre_usuario like '%a%' ;

select count(distinct Nombre_usuario) from Usuarios;

select distinct Nombre_usuario from Usuarios;




select * from Usuarios
order by Nombre_usuario asc;

select * from Usuarios
where edad >=18
order by edad asc;

select max(edad)
from ususario
where edad <=18;


select Nombre_usuario from Usuarios;

select genero, sum(PLATA)
from Usuarios
group by genero;
 
 SET SQL_SAFE_UPDATES=0;