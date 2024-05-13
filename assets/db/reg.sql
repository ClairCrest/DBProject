CREATE TABLE users (
    id int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    balance float(20) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    urole varchar(255) NOT NULL,
    detail_id int(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


