CREATE DATABASE EEmgmt;
USE EEmgmt;

CREATE TABLE login(
username VARCHAR(100) NOT NULL,
pass VARCHAR(300) NOT NULL,
PRIMARY KEY (username));

CREATE TABLE service_user(
idm VARCHAR(30) NOT NULL,
name VARCHAR(30) NOT NULL,
notice VARCHAR(30) NOT NULL,
address VARCHAR(300),
PRIMARY KEY (idm));