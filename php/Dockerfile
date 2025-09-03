FROM php:8.2-apache

# Instalar extensiones PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Instalar msmtp y mailutils
RUN apt-get update && \
    apt-get install -y msmtp mailutils && \
    rm -rf /var/lib/apt/lists/*

# Configurar PHP para usar msmtp
RUN echo "sendmail_path = \"/usr/bin/msmtp -t\"" >> /usr/local/etc/php/conf.d/mail.ini
