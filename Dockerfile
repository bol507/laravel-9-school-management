FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV NVM_DIR=/root/.nvm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash

# Load NVM 
RUN echo 'source $NVM_DIR/nvm.sh' >> /root/.bashrc

# Iinstall nodejs
RUN bash -c "source $NVM_DIR/nvm.sh && \
             nvm install 22 && \
             nvm use 22 && \
             nvm alias default 22"


ENV PATH="$NVM_DIR/versions/node/v20/bin:$PATH"

WORKDIR /var/www/html
