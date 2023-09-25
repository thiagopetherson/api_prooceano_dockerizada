FROM php:8.1-fpm

# Argumentos definidos no docker-compose.yml
ARG user
ARG uid

# Instalando os pacotes do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    git \
    curl \
    zip \
    unzip \
    supervisor \
    default-mysql-client

# Limpando o cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalando extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip sockets

# Pegando o composer e passando para o container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário do sistema (com o usuário que foi pego lá em cima) para rodar o composer e os comandos artisans
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Instalando Redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Setando o diretório de trabalho
WORKDIR /var/www

# Indicando qual usuário estamos utilizando para acessar esse container
USER $user
