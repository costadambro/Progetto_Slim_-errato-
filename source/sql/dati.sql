DROP DATABASE IF EXISTS playlist;
CREATE DATABASE playlist;
USE playlist;
CREATE TABLE accesso(
    email varchar(20) PRIMARY KEY NOT NULL,
    nome varchar(64) NOT NULL,
    cognome varchar(64) NOT NULL,
    pass char(128) NOT NULL
);
CREATE TABLE copiaccesso(
    email varchar(20) PRIMARY KEY NOT NULL,
    nome varchar(64) NOT NULL,
    cognome varchar(64) NOT NULL,
    pass char(128) NOT NULL
);
CREATE TABLE otp(
    idotp int not null PRIMARY KEY auto_increment,
    email varchar(20) NOT NULL,
    otp varchar(128) NOT NULL,
    FOREIGN KEY (email) REFERENCES copiaccesso(email)
);
CREATE TABLE token(
    idtoken int not null PRIMARY KEY auto_increment,
    token varchar(20) NOT NULL,
    email varchar(128) NOT NULL,
    FOREIGN KEY (email) REFERENCES accesso(email)
);
CREATE TABLE canzone(
    codice int not null PRIMARY KEY auto_increment,
    titolo varchar(64) NOT NULL,
    artista varchar(64) NOT NULL,
    feat varchar(64),
    genere varchar(64) NOT NULL,
    durata varchar(64) NOT NULL,
    email varchar(20) NOT NULL,
    FOREIGN KEY (email) REFERENCES accesso(email)
);