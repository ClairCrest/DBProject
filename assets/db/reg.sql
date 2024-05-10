CREATE TABLE users (
    id int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    balance int(11) NOT NULL,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    citizen_ID varchar(255) NOT NULL,
    telephone varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    province varchar(255) NOT NULL, 
    password varchar(255) NOT NULL,
    urole varchar(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


