DROP DATABASE IF EXISTS student_passwords;
CREATE DATABASE student_passwords;
USE student_passwords;

SET block_encryption_mode = 'aes-256-cbc';
SET @key_str = UNHEX(SHA2('my secret passphrase', 256));
SET @init_vector = RANDOM_BYTES(16);

DROP USER IF EXISTS 'passwords_user'@'localhost';
CREATE USER 'passwords_user'@'localhost';
GRANT ALL PRIVILEGES ON student_passwords.* TO 'passwords_user'@'localhost';

CREATE TABLE IF NOT EXISTS student_passwords.people (
  personID smallint(5) NOT NULL AUTO_INCREMENT,
  firstName varchar(50) NOT NULL,
  lastName varchar(50) NOT NULL,
  email varchar(320) NOT NULL,
  comment varchar(60) NULL,
  CONSTRAINT people_PK PRIMARY KEY (personID),
  UNIQUE KEY people_unique (email)
);

CREATE TABLE IF NOT EXISTS student_passwords.websites (
  websiteID smallint(5) NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  url varchar(60) NOT NULL,
  comment varchar(60) DEFAULT NULL,
  CONSTRAINT websites_PK PRIMARY KEY (websiteID),
  UNIQUE KEY websites_unique (url)
);

CREATE TABLE IF NOT EXISTS student_passwords.users (
  personID smallint(5) NOT NULL,
  websiteID smallint(5) NOT NULL,
  username varchar(100) NOT NULL,
  password varchar(1) NOT NULL,
  timestamp datetime NOT NULL,
  comment varchar(60) DEFAULT NULL,
  PRIMARY KEY (username, websiteID),
  CONSTRAINT users_websites_FK FOREIGN KEY (websiteID) REFERENCES websites (websiteID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT users_people_FK FOREIGN KEY (personID) REFERENCES people (personID) ON DELETE CASCADE ON UPDATE CASCADE
);
