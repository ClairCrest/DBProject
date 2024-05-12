CREATE TABLE money_history(
    history_order int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id int(11) NOT NULL,
    old_balance int(11) NOT NULL,
    new_balance int(11) NOT NULL,
    difference int(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;