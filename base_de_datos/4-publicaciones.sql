USE erasmus;
SET NAMES 'utf8mb4';

CREATE TABLE IF NOT EXISTS publicaciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    ubicacion_imagen VARCHAR(255),
    descripcion TEXT,
    pais_id INT NULL, 
    fecha_publicacion DATE,
    hora_publicacion TIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (pais_id) REFERENCES paises(id) ON DELETE RESTRICT
) CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
