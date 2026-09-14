FROM almalinux:8.10

# TimeZoneの設定
RUN echo 'ZONE="Asia/Tokyo"' > /etc/sysconfig/clock

# XAMPPの動作用依存パッケージ
RUN dnf -y update && \
    dnf -y install \
      net-tools \
      git \
      glibc \
      libnsl \
      tar \
      wget \
      which && \
    dnf clean all

RUN wget --version \
    && wget https://downloads.sourceforge.net/project/xampp/XAMPP%20Linux/7.4.11/xampp-linux-x64-7.4.11-0-installer.run \
    && chmod +x xampp-linux-x64-7.4.11-0-installer.run \
    && ./xampp-linux-x64-7.4.11-0-installer.run --version \
    && ./xampp-linux-x64-7.4.11-0-installer.run --enable-components xampp_developer_files --mode unattended

# Composer の最新公式イメージからバイナリだけをコピーする
COPY --from=composer:2.10.3 /usr/bin/composer /usr/local/bin/composer

# XAMPPのPHPをデフォルトの php コマンドとしてパスを通す
ENV PATH="/opt/lampp/bin:${PATH}"

COPY xampp-setup.sh /usr/local/bin/xampp-setup.sh
RUN set -eux \
    && chmod +x /usr/local/bin/xampp-setup.sh \
    && /usr/local/bin/xampp-setup.sh

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN set -eux \
    && chmod +x /usr/local/bin/entrypoint.sh

# WORKDIR、ENTRYPOINT、CMDの順序がお作法
WORKDIR /opt/lampp/htdocs

EXPOSE 80 3306

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/bin/sh", "-c", "/opt/lampp/lampp restart && tail -f /opt/lampp/logs/php_error_log /opt/lampp/logs/error_log"]
