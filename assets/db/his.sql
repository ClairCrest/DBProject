CREATE TABLE history (
    order_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id int(11) NOT NULL,
    target_id int(11) NOT NULL, 
    old_balance float(20) NOT NULL,
    new_balance float(20) NOT NULL,
    difference float(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
