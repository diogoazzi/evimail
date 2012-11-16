
ALTER TABLE user ADD COLUMN usr_celularDDD int(2);
ALTER TABLE user ADD COLUMN usr_telefoneDDD int(2);
ALTER TABLE user ADD COLUMN usr_comercialDDD int(2);
ALTER TABLE user ADD COLUMN usr_document_cpf int(11);
ALTER TABLE user ADD COLUMN usr_document_cnpj int(14);
ALTER TABLE user ADD COLUMN usr_companyname varchar(255);


ALTER TABLE user DROP COLUMN usr_document;

