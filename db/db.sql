CREATE TABLE user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) DEFAULT NULL,
        apellido VARCHAR(255) DEFAULT NULL,
        email VARCHAR(255) NOT NULL,
        codigo VARCHAR(255) NOT NULL
    )