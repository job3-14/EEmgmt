CREATE DATABASE EEmgmt;
USE EEmgmt;

CREATE TABLE login(
id INTEGER  NOT NULL,
username VARCHAR(100) NOT NULL,
pass VARCHAR(300) NOT NULL,
PRIMARY KEY (id));

CREATE TABLE service_user(
idm INTEGER NOT NULL,
notice VARCHAR(30) NOT NULL,
address VARCHAR(300),
PRIMARY KEY (idm));