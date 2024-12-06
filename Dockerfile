# Usar a imagem oficial do PHP com o Apache
FROM php:8.2-apache

# Instalar dependências necessárias e extensões PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    git \
    unzip \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && pecl install redis \
    && docker-php-ext-enable redis

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Copiar arquivos do projeto para o container
COPY . /var/www/html/

# Copy custom Apache configurations and include them in the main configuration
COPY docker/default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/default.conf /etc/apache2/conf-available/apache2.conf
RUN echo "IncludeOptional /etc/apache2/conf-available/apache2.conf" >> /etc/apache2/apache2.conf

# Definir diretório de trabalho no container
WORKDIR /var/www/html

# Instalar dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Rodar o Composer para instalar as dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Expor a porta do Apache
EXPOSE 80

# Comando padrão para rodar o Apache
CMD ["apache2-foreground"]
