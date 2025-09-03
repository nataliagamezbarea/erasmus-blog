USE erasmus;
SET NAMES 'utf8mb4';

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    pais_id INT NULL, -- el país es opcional en usuarios
    es_admin TINYINT(1) NOT NULL DEFAULT 0, 
    codigo_verificacion VARCHAR(18) NULL,
    FOREIGN KEY (pais_id) REFERENCES paises(id) ON DELETE SET NULL
) 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_spanish_ci;
