FROM php:8.5.11-apache-trixie

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
        # composer installで必要 \
        unzip \
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
    && sed -ri --file=/root/php_ini.sed /usr/local/etc/php/php.ini \
    # Xdebug のインストールと有効化 \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Composer の最新公式イメージからバイナリだけをコピーする
COPY --from=composer:2.10.3 /usr/bin/composer /usr/local/bin/composer

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN set -eux \
    && chmod +x /usr/local/bin/entrypoint.sh

# 外部から受け取る引数を定義（デフォルト値 1000）
# macOS のグループIDは 20から始まり、Ubuntu の dialout が使用しているので、GROUP_ID は指定しない
ARG USER_ID=1000

# エントリポイント権限付与、www-data の ID 調整
# 1 つの RUN にまとめてレイヤー増加を防ぐ
RUN set -eux \
    && chmod +x /usr/local/bin/entrypoint.sh \
    && usermod -u ${USER_ID} www-data \
    # make php-lint-baseline 等の実行時に、コンテナ内の /var/www/.gitconfig で Permission denied エラー、その対策 \
    && mkdir -p /var/www/.composer /var/www/.config \
    && chown -R www-data:www-data /var/www

# WORKDIR、ENTRYPOINT、CMDの順序がお作法
WORKDIR /var/www/html

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
