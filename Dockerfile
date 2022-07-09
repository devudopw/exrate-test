FROM r.sync.pw/library/alpine:3.15 AS build

WORKDIR /builddir
USER root

RUN apk update && \
    apk --no-cache add \
    alpine-sdk \
    libevent-dev \
    openssl-dev \
    make \
    php-pear \
    php7-dev \
    php-openssl
RUN printf "no\nyes\n/usr\nno\nyes\nyes\nno\n/usr/bin/openssl" | pecl install event

FROM build AS deps

WORKDIR /depsdir
USER root

RUN apk update && \
    apk --no-cache add \
    php-zip \
    php-curl \
    php-phar \
    php-mbstring \
    php-json \
    unzip \
    git
COPY --from=r.sync.pw/library/composer /usr/bin/composer /usr/bin/composer
COPY data/composer.json ./
RUN composer update \
	--ignore-platform-reqs \
    #--quiet \
	--no-ansi \
	--no-interaction \
	--no-plugins \
	#--no-progress \
	--no-scripts \
	--prefer-dist \
    #--no-dev \
    --optimize-autoloader

FROM r.sync.pw/library/alpine:3.15 AS deploy

ARG PHP_VERSION=7
ARG GID=1000
ARG UID=1000

USER root

RUN apk update && \
    apk --no-cache add \
    libevent \
    php \
    php-common \
    php-sockets \
    php-mysqli \
    php-bcmath \
    php-mbstring \
    php-dom \
    php-json \
    php-phar \
    php-xmlwriter \
    php-tokenizer \
    php-posix \
    php-pcntl

COPY --from=build /usr/lib/php${PHP_VERSION}/modules/event.so /usr/lib/php${PHP_VERSION}/modules/event.so
RUN echo 'extension=event.so' | tee /etc/php${PHP_VERSION}/conf.d/01_event.ini

RUN addgroup --system --gid ${GID} user && \
    adduser -D -H --system -G $(getent group ${GID} | cut -d: -f1) -u ${UID} -s /bin/sh user

COPY --chown=user:user data /data
COPY --chown=user:user --from=deps /depsdir/vendor /data/vendor
COPY --chown=user:user --from=deps /depsdir/composer.lock /data/composer.lock

RUN sed -i "s/error_reporting = E_ALL \& ~E_DEPRECATED \& ~E_STRICT/error_reporting = E_ALL \& ~E_DEPRECATED \& ~E_STRICT \& ~E_NOTICE/g" /etc/php${PHP_VERSION}/php.ini

USER user

EXPOSE 8080/tcp

CMD ["php", "/data/start.php", "start"]
