CREATE TABLE players (
  Player varchar(6) DEFAULT NULL,
  Cash int(4) DEFAULT NULL
);

CREATE TABLE stocks (
  Code varchar(4) DEFAULT NULL,
  Name varchar(10) DEFAULT NULL,
  Category varchar(1) DEFAULT NULL,
  Value int(3) DEFAULT NULL
);

CREATE TABLE transactions (
  Seq int(11) DEFAULT NULL,
  DateTime varchar(19) DEFAULT NULL,
  Agent varchar(19) DEFAULT NULL,
  Player varchar(6) DEFAULT NULL,
  Stock varchar(4) DEFAULT NULL,
  Trans varchar(4) DEFAULT NULL,
  Quantity int(4) DEFAULT NULL
);

CREATE TABLE movement (
  Seq int(11) DEFAULT NULL,
  Datetime varchar(19) DEFAULT NULL,
  Code varchar(4) DEFAULT NULL,
  Action varchar(4) DEFAULT NULL,
  Amount int(11) DEFAULT NULL
);

CREATE TABLE logindata (
  id int(11) NOT NULL,
  password varchar(20) DEFAULT NULL,
  name varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE holding (
  Player varchar(6) DEFAULT NULL,
  Stock varchar(4) DEFAULT NULL,
  Quantity int(4) DEFAULT NULL,
  certificate varchar(40) DEFAULT NULL
);