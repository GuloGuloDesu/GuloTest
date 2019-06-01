CREATE DATABASE CardCounting;

USE CardCounting;

CREATE TABLE tblDarknetCodes 
    (
        pk bigint not null auto_increment primary key,
        DarknetCode varchar(256),
        DateStamp date
    );

CREATE TABLE tblSalt
    (
        pk bigint not null auto_increment primary key,
        Salt varchar(256),
        DateStamp date
    );

CREATE USER 'UserRead'@'localhost' IDENTIFIED BY 'Test123';
GRANT SELECT ON CardCounting.tblDarknetCodes TO 'UserRead'@'localhost';
GRANT SELECT ON CardCounting.tblSalt TO 'UserRead'@'localhost';
