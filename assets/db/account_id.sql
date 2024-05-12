CREATE TABLE account_id (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email varchar(255) NOT NULL,
    pass varchar(40) NOT NULL,
    role_id int(11) NOT NULL,
    acc_detail_id int(11) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;