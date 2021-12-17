drop database if exists modulesdb;
create database if not exists modulesdb;
use modulesdb;

create table modules (
mid char(6), mod_name char(100), 
primary key (mid));

create table assessments (
mid char(6), assess_name char(100), mark integer, 
primary key (mid, assess_name));

load data infile 'Y2modules.txt'
INTO TABLE modules
fields terminated BY ',' enclosed BY '"'
lines terminated BY '\r\n';