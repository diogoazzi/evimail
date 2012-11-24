CREATE TABLE trans_cielo (
  tid char(20) NOT NULL ,
  date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  status int(2) NOT NULL,
  valor int(11) NOT NULL,
  bandeira varchar(50) NOT NULL,
  produto char(1) NOT NULL,
  parcelas int(2) NOT NULL,
  numero_pedido int(11) NOT NULL,

  PRIMARY KEY (tid),
  KEY numero_pedido (numero_pedido),
  CONSTRAINT cielo_credit FOREIGN KEY (numero_pedido) REFERENCES credits (cre_id)
) ENGINE=InnoDB ;
