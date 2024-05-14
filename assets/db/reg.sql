CREATE TABLE users (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    balance float(20) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    role_id int(11) NOT NULL,
    detail_id int(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    FOREIGN KEY (role_id) REFERENCES urole(role_id),
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


