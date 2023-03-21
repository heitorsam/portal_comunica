CREATE USER portal_relatorios IDENTIFIED BY sjc_ping_pong_12_12_2022;

GRANT CREATE SESSION TO portal_relatorios;
GRANT CREATE PROCEDURE TO portal_relatorios;
GRANT CREATE TABLE TO portal_relatorios;
GRANT CREATE VIEW TO portal_relatorios;
GRANT UNLIMITED TABLESPACE TO portal_relatorios;
GRANT CREATE SEQUENCE TO portal_relatorios;

GRANT SELECT ON portal_projetos.SEQ_CD_ACESSO TO portal_relatorios;
GRANT INSERT ON portal_projetos.ACESSO TO portal_relatorios;

GRANT EXECUTE ON dbasgu.FNC_MV2000_HMVPEP TO portal_relatorios;

GRANT SELECT ON dbasgu.USUARIOS TO portal_relatorios;
GRANT SELECT ON dbasgu.PAPEL_USUARIOS TO portal_relatorios;

GRANT SELECT ON dbamv.ATENDIME TO portal_relatorios;
GRANT SELECT ON dbamv.CONVENIO TO portal_relatorios;
GRANT SELECT ON dbamv.PRO_FAT TO portal_relatorios;
