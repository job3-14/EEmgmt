CREATE DATABASE EEmgmt;
USE EEmgmt;

CREATE TABLE login(
username VARCHAR(100) NOT NULL,
pass VARCHAR(300) NOT NULL,
addcard INTEGER NOT NULL,
editcard INTEGER NOT NULL,
sendnotice INTEGER NOT NULL,
viewexit INTEGER NOT NULL,
shutdown INTEGER NOT NULL,
edituser INTEGER NOT NULL,
PRIMARY KEY (username));

CREATE TABLE service_user(
idm VARCHAR(30) NOT NULL,
name VARCHAR(30) NOT NULL,
mainEmail VARCHAR(300) NOT NULL,
notice VARCHAR(30) NOT NULL,
address1 VARCHAR(300),
address2 VARCHAR(300),
address3 VARCHAR(300),
address4 VARCHAR(300),
address5 VARCHAR(300),
PRIMARY KEY (idm));

CREATE TABLE history(
idm VARCHAR(30) NOT NULL,
type VARCHAR(10) NOT NULL,
date DATETIME NOT NULL
);

CREATE TABLE line(
email VARCHAR(300) NOT NULL,
userid VARCHAR(100) NOT NULL,
PRIMARY KEY (email));

CREATE TABLE reservation(
number INTEGER NOT NULL,
idm VARCHAR(30) NOT NULL,
PRIMARY KEY (number));

INSERT INTO login (username,pass,addcard,editcard,sendnotice,viewexit,shutdown,edituser) VALUES ('admin','$2y$10$108SEqGGklDdtM9ZUmX7pOc..SPruetjTaFj9t3QRvJfL//BvmKYa',1,1,1,1,1,1);
