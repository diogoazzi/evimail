-- JOJO fiZ UM novo clone e vieram estes campos somente 
-- com int(14) no cnpj, foi ele que vc alterou
-- to dando um push com ele asssm
-- depois me confirmma se foi isso

ALTER TABLE user ADD COLUMN usr_celularDDD int(2);
ALTER TABLE user ADD COLUMN usr_telefoneDDD int(2);
ALTER TABLE user ADD COLUMN usr_comercialDDD int(2);
ALTER TABLE user ADD COLUMN usr_document_cpf int(11);
ALTER TABLE user ADD COLUMN usr_document_cnpj int(14);
ALTER TABLE user ADD COLUMN usr_companyname varchar(255);


ALTER TABLE user DROP COLUMN usr_document;

-- nova inclusao 17/11

ALTER TABLE email ADD COLUMN ema_body TEXT;
ALTER TABLE email ADD COLUMN ema_usr_id int(11);
ALTER TABLE email ADD FOREIGN KEY (ema_usr_id) REFERENCES user (usr_id);
