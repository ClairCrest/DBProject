CREATE TABLE history (
    id int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    target_id int(11), 
    old_balance float(20) NOT NULL,
    new_balance float(20) NOT NULL,
    difference float(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
