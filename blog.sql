create database blog;
use blog;

CREATE TABLE users (
id INT(11) NOT NULL AUTO_INCREMENT,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
role ENUM('redaktor', 'šéfredaktor', 'admin') NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE articles (
id INT(11) NOT NULL AUTO_INCREMENT,
title VARCHAR(255) NOT NULL,
description TEXT,
content TEXT,
created_at DATETIME NOT NULL,
published_at DATETIME,
author_id INT(11) NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (author_id) REFERENCES users(id)
);
