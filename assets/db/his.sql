CREATE TABLE history (
    id int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    target_id int(11), 
    old_balance int(11) NOT NULL,
    new_balance int(11) NOT NULL,
    difference int(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
