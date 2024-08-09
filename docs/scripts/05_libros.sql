-- Active: 1709594423259@@127.0.0.1@3306@nwdb
CREATE TABLE libros(  
    libros_id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    libros_dsc varchar(250) NOT NULL,
    libros_isbn varchar(25) NOT NULL,
    libros_autor varchar(250) NOT NULL,
    libros_categoria char(3) NOT NULL,
    libros_estado char(3) NOT NULL
) COMMENT '';