CREATE TABLE acc_detail (
    detail_id int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    citizen_ID varchar(255) NOT NULL,
    telephone varchar(255) NOT NULL,
    address_id int(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;