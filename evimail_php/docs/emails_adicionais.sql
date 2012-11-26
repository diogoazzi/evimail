CREATE TABLE emails_adicionais (
	id int(11) NOT NULL AUTO_INCREMENT,
	email varchar(255),
	usr_id int(11) NOT NULL,
	create_date timestamp NOT NULL,
	
	PRIMARY KEY(id),
	KEY usr_id (usr_id),
	CONSTRAINT ema_adi_usr_id FOREIGN KEY (usr_id) REFERENCES user (usr_id)
) ENGINE=InnoDB;
