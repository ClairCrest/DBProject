CREATE TABLE user (
    id int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    citiizen_ID int(15) NOT NULL,
    telephone int(11) NOT NULL,
    email varchar(255) NOT NULL,
    province varchar(255) NOT NULL, 
    password varchar(100) NOT NULL,
    urole varchar(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;