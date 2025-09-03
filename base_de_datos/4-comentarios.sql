USE erasmus;
SET NAMES 'utf8mb4';

CREATE TABLE IF NOT EXISTS comentarios (
    IDComentario INT PRIMARY KEY AUTO_INCREMENT,
    UsuarioID INT NOT NULL,  -- Clave foránea que se relaciona con 'usuarios'
    TextoComentario TEXT NOT NULL,
    FechaComentario DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UsuarioID) REFERENCES usuarios(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
