# Erasmus Blog

Bienvenido al repositorio de **Erasmus Blog**, un proyecto pensado para que los estudiantes Erasmus compartan sus experiencias, consejos y recursos útiles sobre vivir y estudiar en el extranjero.

Este README está diseñado para que cualquier empresa o desarrollador entienda rápidamente cómo funciona el proyecto, cómo se instala con Docker y cuál es la estructura y tecnologías que utiliza.

---

## Tabla de Contenidos

- [¿Qué es Erasmus Blog?](#qué-es-erasmus-blog)
- [Tecnologías Utilizadas](#tecnologías-utilizadas)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Instalación y despliegue con Docker](#instalación-y-despliegue-con-docker)
- [Funcionamiento general](#funcionamiento-general)
- [Contacto](#contacto)

---

## ¿Qué es Erasmus Blog?

Este repositorio contiene el código fuente de una plataforma web desarrollada principalmente con PHP, HTML, CSS y JavaScript, orientada a la publicación de artículos y recursos relacionados con la experiencia Erasmus. El objetivo es crear una comunidad colaborativa donde los usuarios puedan publicar, comentar y consultar información útil.

---

## Tecnologías Utilizadas

El proyecto está construido con las siguientes tecnologías:

- **PHP**: Motor principal del backend, encargado de la lógica de la aplicación y la conexión a la base de datos.
- **HTML & CSS & SCSS**: Para la estructura y el diseño visual de las páginas.
- **JavaScript**: Añade interactividad en el frontend.
- **Docker & Docker Compose**: Facilitan la instalación y el despliegue en cualquier entorno.
- **MySQL/MariaDB**: Base de datos relacional (estructura en `/base_de_datos`).
- **Hack**: Algunos scripts y utilidades internas.
- **Otros**: Archivos puntuales en otros lenguajes para funcionalidad específica.

---

## Estructura del Proyecto

La raíz del repositorio contiene los siguientes directorios y archivos clave:

```
/
├── base_de_datos/       # Scripts y estructura de la base de datos
├── docker-compose.yml   # Configuración para levantar los servicios con Docker
├── php/                 # Código fuente backend en PHP
├── public/              # Archivos estáticos y frontend (HTML, CSS, JS, imágenes)
├── readme.md            # Este archivo (documentación)
```

- **`base_de_datos/`**: Aquí se encuentran los scripts SQL para crear y poblar la base de datos del blog.
- **`docker-compose.yml`**: Define los contenedores para la aplicación PHP, la base de datos y otros servicios necesarios.
- **`php/`**: Lógica del servidor, controladores, vistas y modelos en PHP.
- **`public/`**: Archivos públicos accesibles desde el navegador (principalmente frontend).
- **`readme.md`**: Documentación del proyecto.

---

## Instalación y despliegue con Docker

Para facilitar la instalación y evitar problemas de dependencias, el proyecto viene preparado para ejecutarse con Docker. Solo necesitas tener instalado **Docker** y **Docker Compose**.

### Pasos para levantar el proyecto

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/nataliagamezbarea/erasmus-blog.git
   cd erasmus-blog
   ```

2. **Levantar los servicios con Docker Compose**

   ```bash
   docker-compose up --build
   ```

   Esto levantará los siguientes servicios:
   - **PHP/Apache**: Servidor web donde corre la aplicación.
   - **MySQL/MariaDB**: Base de datos del blog.
   - Otros servicios definidos en el `docker-compose.yml`.

3. **Acceder a la aplicación**

   Por defecto, la aplicación estará disponible en [http://localhost:8080/fronted/Inicio](http://localhost:8080/fronted/Inicio) .

   Para acceder a phpmyadmin http://localhost:8081 ( un gestor de base de base de datos).

### Notas importantes

- Los datos de la base de datos se inicializan usando los scripts de `/base_de_datos`.
- Puedes modificar la configuración de puertos y credenciales en el `docker-compose.yml`.
- Para detener los servicios, ejecuta `docker-compose down`.

---

## Funcionamiento general

- Los usuarios pueden registrarse, iniciar sesión y publicar artículos.
- Los artículos se almacenan en la base de datos y se muestran en la web pública.
- Hay funcionalidades de búsqueda, filtrado y comentarios.
- La lógica principal está en el directorio `php/`, mientras que el frontend se gestiona en `public/`.
- La estructura de las tablas SQL está bien definida para soportar usuarios, artículos y comentarios.
