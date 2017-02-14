#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
# ETML
# Auteur  : Merk Yann
# Date    : 14.02.2017
# Summary : Init script for the database used in the P_Web2 Project


DROP DATABASE IF EXISTS db_P_Web;
CREATE DATABASE db_P_Web;
USE db_P_Web;

#------------------------------------------------------------
# Table: t_books
#------------------------------------------------------------

CREATE TABLE t_books(
        idBook         int (11) Auto_increment  NOT NULL ,
        booTitle       Varchar (50) NOT NULL ,
        booPageNumber  Int NOT NULL ,
        booExtractLink Varchar (50) ,
        booSummary     Varchar (5000) ,
        booReleaseYear Date NOT NULL ,
        booPictureLink Varchar (50) ,
        idBookType     Int NOT NULL ,
        idAuthor       Int NOT NULL ,
        idEditor       Int NOT NULL ,
        idUser         Int NOT NULL ,
        PRIMARY KEY (idBook )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_category
#------------------------------------------------------------

CREATE TABLE t_category(
        idCategory     int (11) Auto_increment  NOT NULL ,
        catName        Varchar (30) NOT NULL ,
        catDescription Varchar (150) ,
        PRIMARY KEY (idCategory )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_bookType
#------------------------------------------------------------

CREATE TABLE t_bookType(
        idBookType int (11) Auto_increment  NOT NULL ,
        btName     Varchar (30) NOT NULL ,
        PRIMARY KEY (idBookType )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_author
#------------------------------------------------------------

CREATE TABLE t_author(
        idAuthor     int (11) Auto_increment  NOT NULL ,
        autName      Varchar (50) NOT NULL ,
        autFirstname Varchar (50) NOT NULL ,
        PRIMARY KEY (idAuthor )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_editor
#------------------------------------------------------------

CREATE TABLE t_editor(
        idEditor int (11) Auto_increment  NOT NULL ,
        ediName  Varchar (50) NOT NULL ,
        PRIMARY KEY (idEditor )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_user
#------------------------------------------------------------

CREATE TABLE t_user(
        idUser           int (11) Auto_increment  NOT NULL ,
        useNickname      Varchar (30) NOT NULL ,
        useRegisteryDate Date NOT NULL ,
        usePassword      Varchar (50) NOT NULL ,
        PRIMARY KEY (idUser )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_categorize
#------------------------------------------------------------

CREATE TABLE t_categorize(
        idBook     Int NOT NULL ,
        idCategory Int NOT NULL ,
        PRIMARY KEY (idBook ,idCategory )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_rating
#------------------------------------------------------------

CREATE TABLE t_rating(
        ratRating Int NOT NULL ,
        idUser    Int NOT NULL ,
        idBook    Int NOT NULL ,
        PRIMARY KEY (idUser ,idBook )
)ENGINE=InnoDB;

ALTER TABLE t_books ADD CONSTRAINT FK_t_books_idBookType FOREIGN KEY (idBookType) REFERENCES t_bookType(idBookType);
ALTER TABLE t_books ADD CONSTRAINT FK_t_books_idAuthor FOREIGN KEY (idAuthor) REFERENCES t_author(idAuthor);
ALTER TABLE t_books ADD CONSTRAINT FK_t_books_idEditor FOREIGN KEY (idEditor) REFERENCES t_editor(idEditor);
ALTER TABLE t_books ADD CONSTRAINT FK_t_books_idUser FOREIGN KEY (idUser) REFERENCES t_user(idUser);
ALTER TABLE t_categorize ADD CONSTRAINT FK_t_categorize_idBook FOREIGN KEY (idBook) REFERENCES t_books(idBook);
ALTER TABLE t_categorize ADD CONSTRAINT FK_t_categorize_idCategory FOREIGN KEY (idCategory) REFERENCES t_category(idCategory);
ALTER TABLE t_rating ADD CONSTRAINT FK_t_rating_idUser FOREIGN KEY (idUser) REFERENCES t_user(idUser);
ALTER TABLE t_rating ADD CONSTRAINT FK_t_rating_idBook FOREIGN KEY (idBook) REFERENCES t_books(idBook);
