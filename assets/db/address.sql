CREATE TABLE address(
    address_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    country varchar(255) NOT NULL,
    province varchar(255) NOT NULL,
    zip_code int(11) NOT NULL 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;