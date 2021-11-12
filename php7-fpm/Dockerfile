FROM php:7.3-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y git unzip openssl procps acl zlib1g-dev librabbitmq-dev libssh-dev supervisor nano libzip-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql bcmath zip

# Install amqp extension
RUN pecl install -o -f amqp && rm -rf /tmp/pear && docker-php-ext-enable amqp

# Install Redis extension
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

# Install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Create an alias for Symfony3 console
RUN echo 'alias symfony="php bin/console"' >> ~/.bashrc

# Create supervisor workers
RUN touch -a /etc/supervisor/conf.d/messenger-worker.conf
RUN echo ";/etc/supervisor/conf.d/messenger-worker.conf" >> /etc/supervisor/conf.d/messenger-worker.conf
RUN echo "[program:messenger-consume]" >> /etc/supervisor/conf.d/messenger-worker.conf
RUN echo "command=php /var/www/symfony/bin/console messenger:consume async --time-limit=3600" >> /etc/supervisor/conf.d/messenger-worker.conf
RUN echo "user=root" >> /etc/supervisor/conf.d/messenger-worker.conf
RUN echo "numprocs=2" >> /etc/supervisor/conf.d/messenger-worker.conf
RUN echo "startsecs=0" >> /etc/supervisor/conf.d/messenger-worker.conf
RUN echo "autostart=true" >> /etc/supervisor/conf.d/messenger-worker.conf
RUN echo "autorestart=true" >> /etc/supervisor/conf.d/messenger-worker.conf
RUN echo "process_name=%(program_name)s_%(process_num)02d" >> /etc/supervisor/conf.d/messenger-worker.conf

# Run supervisor workers
RUN cd /etc/supervisor/conf.d
RUN service supervisor start messenger-consume:*

WORKDIR /var/www/symfony
