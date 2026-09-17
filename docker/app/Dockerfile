FROM php:7.4.11-apache-buster

# EOLとなったDebian Busterのリポジトリを archive.debian.org へ切り替え
RUN sed -i -e 's/deb.debian.org/archive.debian.org/g' \
           -e 's/security.debian.org\/debian-security/archive.debian.org\/debian-security/g' \
           -e '/buster-updates/d' /etc/apt/sources.list

# PHP Core Extensions
# @see https://hub.docker.com/_/php
# mbstring はデフォルトでインストール済み
# pdo はデフォルトでインストール済み
# dom はデフォルトでインストール済み
# xml はデフォルトでインストール済み
RUN set -x \
    # TimeZoneの設定 \
    && ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        # gd関数で必要 \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        # intl xml関数で必要 \
        libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        mysqli \
        pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY *.sed /root/

RUN set -x \
    && cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    && sed -ri --file=/root/php_ini.sed /usr/local/etc/php/php.ini

# Composer の最新公式イメージからバイナリだけをコピーする
COPY --from=composer:2.10.3 /usr/bin/composer /usr/local/bin/composer

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN set -eux \
    && chmod +x /usr/local/bin/entrypoint.sh

ARG USER_ID=1000
ARG GROUP_ID=1000
# エントリポイント権限付与、www-data の ID 調整
# 1 つの RUN にまとめてレイヤー増加を防ぐ
RUN set -eux \
    && chmod +x /usr/local/bin/entrypoint.sh \
    && usermod -u ${USER_ID} www-data \
    && groupmod -g ${GROUP_ID} www-data

# WORKDIR、ENTRYPOINT、CMDの順序がお作法
WORKDIR /var/www/html

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
