USE erasmus;
SET NAMES 'utf8mb4';


CREATE TABLE IF NOT EXISTS likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    publicacion_id INT NOT NULL,
    fecha_like DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- Asegura que un usuario solo pueda dar like una vez por publicación
    UNIQUE KEY unico_like (usuario_id, publicacion_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (publicacion_id) REFERENCES publicaciones(id) ON DELETE CASCADE
) 
CHARACTER SET utf8 
COLLATE utf8_spanish2_ci;
