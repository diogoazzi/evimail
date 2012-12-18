CREATE TABLE confirmacao_destinatarios (
    id int(11) not null AUTO_INCREMENT,
    usr_id int(11) not null,
    ema_id int(11) not null,
    status char(1) not null,
    primary key(id)
) engine = InnoDB;

ALTER TABLE confirmacao_destinatarios ADD CONSTRAINT `cd_usr_id` FOREIGN KEY (usr_id) REFERENCES user (usr_id);
ALTER TABLE confirmacao_destinatarios ADD CONSTRAINT `cd_ema_id` FOREIGN KEY (ema_id) REFERENCES email (ema_id);
