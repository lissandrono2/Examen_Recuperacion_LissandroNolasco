CREATE TABLE Productos(  
    product_ww_id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    product_ww_name VARCHAR(128) NOT NULL COMMENT 'Category Name',
    product_ww_small_desc VARCHAR(255),
    product_ww_status CHAR(3) DEFAULT 'ACT' COMMENT 'Status',
    create_time DATETIME COMMENT 'Create Time' DEFAULT CURRENT_TIMESTAMP,
    update_time DATETIME COMMENT 'Update Time' DEFAULT CURRENT_TIMESTAMP
) COMMENT 'Table for Productos WW';