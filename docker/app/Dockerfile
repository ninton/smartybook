FROM php:8.5.10-apache-trixie

# PHP Core Extensions
# @see https://hub.docker.com/_/php
# mbstring はデフォルトでインストール済み
# pdo はデフォルトでインストール済み
# dom はデフォルトでインストール済み
# xml はデフォルトでインストール済み
RUN set -x \
    # TimeZoneの設定 \
    && ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
    && apt-get update -o Acquire::Check-Valid-Until=false || apt-get update \
    && apt-get install -y --no-install-recommends \
        # CLI用 mysql コマンド \
        default-mysql-client \
        # Golden Master Test 前後のデータリセットで必要 \
        git \
        # gd関数で必要 \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        # intl で必要 \
        libicu-dev \
        # intl xml関数で必要 \
        libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        # composer-require-checker ^4.18 で必要 \
        bcmath \
        gd \
        # composer-require-checker ^4.18 で必要 \
        intl \
        mysqli \
        pdo_mysql \
        # smarty/smarty のinstallで必要
        zip \
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
