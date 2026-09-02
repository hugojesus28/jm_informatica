CREATE DATABASE IF NOT EXISTS teste_tecnico
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE jm_informatica;

CREATE TABLE `user` (
    id_user BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    /* alterei para 255 para aceitar senhas criptografadas maiores */
    password VARCHAR(45) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ativo TINYINT(1)
);

CREATE TABLE service (
    id_service BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(45) NOT NULL,
    price DECIMAL(11,3) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    finished_at DATETIME NULL,
    commission_user DECIMAL(11,3) NULL,
    user_id_user BIGINT(20) NOT NULL,

    CONSTRAINT fk_service_user
        FOREIGN KEY (user_id_user)
        REFERENCES `user`(id_user)
        ON DELETE CASCADE
);