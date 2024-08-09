CREATE TABLE products(  
    productId int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    productName VARCHAR(128) NOT NULL COMMENT 'Product Name',
    productDescription VARCHAR(255),
    productImgUrl CHAR(128),
    productPrice DECIMAL(13,2) NOT NULL DEFAULT 0,
    productStatus CHAR(3) DEFAULT 'ACT' COMMENT 'Status'
);