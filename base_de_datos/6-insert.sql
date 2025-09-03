USE erasmus;
SET NAMES 'utf8mb4';
-- Insertamos los países
INSERT INTO paises (nombre) VALUES
('Dinamarca'),
('Finlandia'),
('Francia'),
('Irlanda'),
('Portugal'),
('Italia'),
('Malta'),
('Republica Checa'),
('Polonia'),
('Estonia');




INSERT INTO usuarios (nombre_usuario, email, password, pais_id, es_admin, codigo_verificacion)
VALUES 
('root', 'root123@gmail.com', '$2y$10$FVQ7CUY9zI5SbCl/EUbx8OT8vJWbCO4Feen0/jW0JXKOu/Vb.tlx6', NULL, 0, NULL);






-- Dinamarca (id = 1)
INSERT INTO publicaciones (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) VALUES
(1, 'Explorando Copenhague', '/backend/imagenes_erasmus/1-dinamarca.jpg',
'Un viaje inolvidable por Copenhague, donde los canales pintorescos se entrelazan con calles llenas de historia y cafeterías acogedoras. Desde el icónico puerto de Nyhavn hasta los jardines de Tivoli, cada rincón refleja la esencia danesa de bienestar y diseño escandinavo.', 
1, '2025-08-01', '09:00:00'),
(1, 'Vida cotidiana danesa', '/backend/imagenes_erasmus/2-dinamarca.jpg',
'Descubre la vida cotidiana en Dinamarca, con sus bicicletas omnipresentes, la pasión por el hygge y la arquitectura minimalista. Camina por barrios históricos, disfruta de mercados locales y empápate de la calidez y orden que caracteriza a este país nórdico.', 
1, '2025-08-02', '11:30:00'),
(1, 'Castillos y leyendas danesas', '/backend/imagenes_erasmus/3-dinamarca.jpg',
'Un recorrido por los majestuosos castillos daneses, desde Kronborg hasta Frederiksborg, acompañado de fascinantes historias y leyendas medievales. La combinación de arquitectura, arte y relatos históricos hace que cada visita sea mágica y enriquecedora.', 
1, '2025-08-03', '14:00:00');

-- Finlandia (id = 2)
INSERT INTO publicaciones (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) VALUES
(1, 'Auroras boreales en Laponia', '/backend/imagenes_erasmus/4-finlandia.jpg',
'La experiencia única de contemplar auroras boreales en el cielo helado de Laponia. Un espectáculo de luces que danza sobre paisajes nevados, acompañado de la tranquilidad del silencio nórdico y la calidez de los refugios finlandeses.', 
2, '2025-08-04', '20:00:00'),
(1, 'Lagos y saunas finlandesas', '/backend/imagenes_erasmus/5-finlandia.jpg',
'Explora los numerosos lagos de Finlandia, donde la naturaleza se encuentra en su máxima expresión. Sumérgete en aguas cristalinas, pasea por bosques infinitos y disfruta de la tradición de la sauna finlandesa, que combina relajación y socialización de manera única.', 
2, '2025-08-05', '16:00:00');

-- Irlanda (id = 4)
INSERT INTO publicaciones (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) VALUES
(1, 'Acantilados y verdes infinitos', '/backend/imagenes_erasmus/12-irlanda.jpg',
'Los acantilados de Irlanda ofrecen vistas que parecen sacadas de un cuento. Las colinas verdes se extienden hasta donde alcanza la vista, con senderos que conducen a paisajes salvajes, playas escondidas y la sensación de libertad absoluta.', 
4, '2025-08-06', '09:00:00'),
(1, 'Castillos medievales', '/backend/imagenes_erasmus/13-irlanda.jpg',
'Explora los castillos medievales de Irlanda, desde fortalezas imponentes hasta ruinas encantadoras. Cada piedra cuenta historias de batallas, leyendas y tradiciones, ofreciendo una experiencia que combina historia, arquitectura y misterio.', 
4, '2025-08-07', '14:30:00');

-- Portugal (id = 5)
INSERT INTO publicaciones (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) VALUES
(1, 'Rincones históricos de Lisboa', '/backend/imagenes_erasmus/10-portugal.jpeg',
'Lisboa se revela entre colinas y barrios antiguos con tranvías que recorren calles empedradas. Cada esquina ofrece miradores con vistas espectaculares, azulejos que cuentan historias y la vibrante vida de cafés y mercados locales.', 
5, '2025-08-08', '10:00:00'),
(1, 'Delicias portuguesas', '/backend/imagenes_erasmus/11-portugal.jpg',
'Un viaje gastronómico por Portugal, desde los pasteles de nata en Lisboa hasta los platos tradicionales de bacalao. Cada bocado refleja la historia y la riqueza cultural del país, haciendo que cada comida sea una experiencia memorable.', 
5, '2025-08-09', '12:00:00');

-- Malta (id = 7)
INSERT INTO publicaciones (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) VALUES
(1, 'Playas paradisíacas', '/backend/imagenes_erasmus/14-malta.jpg',
'Playas de aguas cristalinas y arena dorada, perfectas para relajarse y disfrutar del sol. Explora calas escondidas y recorre costas llenas de historia y cultura mediterránea.', 
7, '2025-08-10', '11:00:00'),
(1, 'Mdina la silenciosa', '/backend/imagenes_erasmus/15-malta.jpg',
'Mdina, la ciudad amurallada, ofrece un viaje al pasado con calles estrechas, arquitectura medieval y una atmósfera que transporta a tiempos antiguos. Ideal para paseos tranquilos y fotografías únicas.', 
7, '2025-08-11', '15:00:00');

-- Italia (id = 6)
INSERT INTO publicaciones (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) VALUES
(1, 'Roma eterna', '/backend/imagenes_erasmus/8-italia.jpg',
'Descubre Roma, una ciudad donde cada calle y plaza está impregnada de historia. Del Coliseo al Panteón, pasando por sus fuentes y plazas, cada rincón revela la grandeza del arte y la arquitectura italiana.', 
6, '2025-08-12', '09:30:00'),
(1, 'Venecia de ensueño', '/backend/imagenes_erasmus/9-italia.jpg',
'Pasea por los canales de Venecia, rodeado de puentes históricos y góndolas que cruzan silenciosamente el agua. Una experiencia romántica que combina historia, arte y encanto único.', 
6, '2025-08-13', '13:00:00');

-- Republica Checa (id = 8)
INSERT INTO publicaciones (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) VALUES
(1, 'Praga medieval', '/backend/imagenes_erasmus/16-republica_checa.jpg',
'Praga, con su casco antiguo y sus calles empedradas, es un viaje al pasado. Cada edificio y puente cuenta la historia de la ciudad y su rica tradición cultural.', 
8, '2025-08-14', '10:00:00'),
(1, 'Cervecerías tradicionales', '/backend/imagenes_erasmus/17-republica_checa.jpg',
'Recorre las cervecerías tradicionales de Praga y descubre la cultura cervecera checa. Cada sorbo de cerveza es una experiencia que conecta con la historia y la vida social local.', 
8, '2025-08-15', '17:00:00');

-- Polonia (id = 9)
INSERT INTO publicaciones (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) VALUES
(1, 'Cracovia y Wawel', '/backend/imagenes_erasmus/18-polonia.jpg',
'Explora Cracovia, con su casco antiguo y el Castillo de Wawel, lleno de historia y leyendas. Cada calle y plaza respira la historia medieval de Polonia.', 
9, '2025-08-16', '09:00:00'),
(1, 'Montañas y lagos', '/backend/imagenes_erasmus/19-polonia.jpg',
'Parques y montañas de Polonia donde el senderismo y la naturaleza se combinan para ofrecer paisajes impresionantes y tranquilos retiros en medio de bosques y lagos.', 
9, '2025-08-17', '14:00:00');

-- Estonia (id = 10)
INSERT INTO publicaciones (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) VALUES
(1, 'Tallin medieval', '/backend/imagenes_erasmus/20-estonia.jpg',
'Tallin, con su casco antiguo perfectamente conservado, es un viaje a la Edad Media. Murallas, torres y calles empedradas crean un ambiente mágico que transporta a otra época.', 
10, '2025-08-18', '10:30:00'),
(1, 'Saunas y tradiciones', '/backend/imagenes_erasmus/21-estonia.jpg',
'Experimenta las auténticas saunas estonias y la cultura local de bienestar. Un viaje sensorial que combina tradición, relajación y la belleza del paisaje natural.', 
10, '2025-08-19', '16:00:00');
