# Usar a imagem oficial do PHP 8.0 CLI
FROM php:8.0-cli


RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zlib1g-dev \
    pkg-config \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Instalar outras extensões PHP necessárias (se houver)
RUN docker-php-ext-install pdo pdo_mysql

# Baixar e instalar o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar todos os arquivos do projeto para o diretório de trabalho do container
COPY . /var/www/html

# Definir o diretório de trabalho como o diretório de aplicação
WORKDIR /var/www/html

# Expor a porta (caso necessário para outras configurações)
EXPOSE 8000

# Definir o comando para rodar o servidor embutido PHP
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]