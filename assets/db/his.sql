CREATE TABLE history (
    order_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id int(11) NOT NULL,
    target_id int(11) NOT NULL, 
    old_balance float(20) NOT NULL,
    new_balance float(20) NOT NULL,
    difference float(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ref_id varchar(255) NOT NULL,
    vat_type varchar(255) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
