#CREATE DATABASE portal_comunica;

#USE portal_comunica;

#DROPANDO TODAS AS FKS PARA EXCLUIR AS TABELAS
ALTER TABLE portal_comunica.USUARIO DROP FOREIGN KEY FK_EMPRESA_USUARIO;
ALTER TABLE portal_comunica.GRUPO DROP FOREIGN KEY FK_EMPRESA_GRUPO;
ALTER TABLE portal_comunica.GRUPO_USUARIO DROP FOREIGN KEY FK_GRUPO_GRUPO_USUARIO;
ALTER TABLE portal_comunica.CHAMADO DROP FOREIGN KEY FK_EMPRESA_CHAMADO;
ALTER TABLE portal_comunica.CHAMADO DROP FOREIGN KEY FK_GRUPO_CHAMADO;
ALTER TABLE portal_comunica.ITCHAMADO DROP FOREIGN KEY FK_CHAMADO_ITCHAMADO;

DROP TABLE portal_comunica.EMPRESA;
CREATE TABLE portal_comunica.EMPRESA(
	CD_EMPRESA INT PRIMARY KEY AUTO_INCREMENT,
    DS_EMPRESA VARCHAR(30) NOT NULL,
	CD_USUARIO_CADASTRO INT NOT NULL,
    HR_CADASTRO TIMESTAMP NOT NULL,
    CD_USUARIO_ULT_ALT INT,
    HR_ULT_ALT DATETIME
    
);

DROP TABLE portal_comunica.USUARIO;
CREATE TABLE portal_comunica.USUARIO(
	CD_USUARIO INT PRIMARY KEY AUTO_INCREMENT,
    NM_USUARIO VARCHAR(80) NOT NULL,
    DT_NASCIMENTO DATE NOT NULL,
    EMAIL VARCHAR(80) NOT NULL,
    FOTO VARCHAR(200) NULL,
    CD_EMPRESA INT NOT NULL, #FK DA TABELA EMPRESA
    TP_USUARIO VARCHAR(1) NOT NULL,
    CPF VARCHAR(11) NOT NULL,
    SENHA VARCHAR(30) NOT NULL,
    CD_USUARIO_CADASTRO INT NOT NULL,
    HR_CADASTRO TIMESTAMP NOT NULL,
    CD_USUARIO_ULT_ALT INT NULL,
    HR_ULT_ALT DATETIME,
    
    CONSTRAINT FK_EMPRESA_USUARIO FOREIGN KEY (CD_EMPRESA) REFERENCES portal_comunica.EMPRESA (CD_EMPRESA)
);

DROP TABLE portal_comunica.GRUPO;
CREATE TABLE portal_comunica.GRUPO(
	CD_GRUPO INT PRIMARY KEY AUTO_INCREMENT,
    DS_GRUPO VARCHAR(30) NOT NULL,
    CD_EMPRESA INT NOT NULL, #FK DA TABELA EMPRESA
    CD_USUARIO_CADASTRO INT NOT NULL,
    HR_CADASTRO TIMESTAMP NOT NULL,
    CD_USUARIO_ULT_ALT INT NULL,
    HR_ULT_ALT DATETIME NULL,
    
    CONSTRAINT FK_EMPRESA_GRUPO FOREIGN KEY (CD_EMPRESA) REFERENCES portal_comunica.EMPRESA (CD_EMPRESA)
);

DROP TABLE portal_comunica.GRUPO_USUARIO;
CREATE TABLE portal_comunica.GRUPO_USUARIO(
	CD_GRUPO_USUARIO INT PRIMARY KEY AUTO_INCREMENT,
    CD_GRUPO INT NOT NULL, #FK TABELA GRUPO
    CD_USUARIO INT NOT NULL,
    CD_USUARIO_CADASTRO INT NOT NULL,
    HR_CADASTRO TIMESTAMP NOT NULL,
    CD_USUARIO_ULT_ALT VARCHAR(20) NULL,
    HR_ULT_ALT DATETIME NULL,
    
    CONSTRAINT FK_GRUPO_GRUPO_USUARIO FOREIGN KEY (CD_GRUPO) REFERENCES portal_comunica.GRUPO (CD_GRUPO)
);

DROP TABLE portal_comunica.CHAMADO;
CREATE TABLE portal_comunica.CHAMADO(
	CD_CHAMADO INT PRIMARY KEY AUTO_INCREMENT,
    DS_CHAMADO VARCHAR(80) NOT NULL,
    CD_EMPRESA INT NOT NULL, #FK DA TABELA EMPRESA
    CD_GRUPO INT NOT NULL, #FK DA TEBELA GRUPO
    TP_PRIORIDADE VARCHAR(1) NOT NULL,
    DT_PREVISTA DATE NOT NULL,
    TP_STATUS VARCHAR(1) NOT NULL,
    OBS_MENSAGEM BLOB NULL,
    ANEXO VARCHAR(200) NULL,
    EXT VARCHAR(5) NULL,
    CD_USUARIO_RESPONSAVEL INT NULL,
    HR_RESPONSAVEL INT NULL,
    CD_USUARIO_CADASTRO INT NOT NULL,
    HR_CADASTRO DATETIME NOT NULL,
    CD_USUARIO_ULT_ALT INT NULL,
    HR_ULT_ALT DATETIME NULL,
    
	CONSTRAINT FK_EMPRESA_CHAMADO FOREIGN KEY (CD_EMPRESA) REFERENCES portal_comunica.EMPRESA (CD_EMPRESA),
    CONSTRAINT FK_GRUPO_CHAMADO FOREIGN KEY (CD_GRUPO) REFERENCES portal_comunica.GRUPO (CD_GRUPO)
);

DROP TABLE portal_comunica.ITCHAMADO;
CREATE TABLE portal_comunica.ITCHAMADO(
	CD_ITCHAMADO INT PRIMARY KEY AUTO_INCREMENT,
    CD_CHAMADO INT, #FK DA TABELA CHAMADO
    DS_MENSAGEM BLOB NOT NULL,
    ANEXO VARCHAR(200) NULL,
    EXT VARCHAR(5) NULL,
    CD_USUARIO_CADASTRO INT NOT NULL, #FK DA TABELA CHAMADO
    HR_CADASTRO DATETIME NOT NULL,
    CD_USUARIO_ULT_ALT VARCHAR(20) NULL,
    HR_ULT_ALT DATETIME NULL,
    
    CONSTRAINT FK_CHAMADO_ITCHAMADO FOREIGN KEY (CD_CHAMADO) REFERENCES portal_comunica.CHAMADO (CD_CHAMADO)
);

SELECT * FROM portal_comunica.EMPRESA;
SELECT * FROM portal_comunica.USUARIO;
SELECT * FROM portal_comunica.GRUPO;
SELECT * FROM portal_comunica.GRUPO_USUARIO;
SELECT * FROM portal_comunica.CHAMADO;
SELECT * FROM portal_comunica.ITCHAMADO;

#DESABILITA A OPÇÃO DO MYSQL DE DAR UPDATE/DELETE APENAS COM PRIMARY KEY
#SET SQL_SAFE_UPDATES = 0;