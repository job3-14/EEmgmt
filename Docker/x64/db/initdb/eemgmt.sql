CREATE DATABASE EEmgmt;
USE EEmgmt;

CREATE TABLE login(
username VARCHAR(100) NOT NULL,
pass VARCHAR(300) NOT NULL,
p-addcard INTEGER NOT NULL,
p-editcard INTEGER NOT NULL,
p-sendnotice INTEGER NOT NULL,
p-viewexit INTEGER NOT NULL,
p-viewloginlog INTEGER NOT NULL,
p-deletelog INTEGER NOT NULL,
p-initialize INTEGER NOT NULL,
p-setmail INTEGER NOT NULL,
p-shutdown INTEGER NOT NULL,
p-edituser INTEGER NOT NULL,
PRIMARY KEY (username));

CREATE TABLE service_user(
idm VARCHAR(30) NOT NULL,
name VARCHAR(30) NOT NULL,
notice VARCHAR(30) NOT NULL,
address VARCHAR(300),
PRIMARY KEY (idm));
