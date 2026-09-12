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

RUN wget --version
RUN wget https://downloads.sourceforge.net/project/xampp/XAMPP%20Linux/7.4.11/xampp-linux-x64-7.4.11-0-installer.run
RUN chmod +x xampp-linux-x64-7.4.11-0-installer.run
RUN ./xampp-linux-x64-7.4.11-0-installer.run --version
RUN ./xampp-linux-x64-7.4.11-0-installer.run --enable-components xampp_developer_files --mode unattended

# Composer の最新公式イメージからバイナリだけをコピーする
# PEAR対応のため、暫定で composer 1 を使います
COPY --from=composer:1 /usr/bin/composer /usr/local/bin/composer

# XAMPPのPHPをデフォルトの php コマンドとしてパスを通す
ENV PATH="/opt/lampp/bin:${PATH}"

COPY xampp_setup.sh /usr/local/bin/xampp_setup.sh
RUN set -eux \
    && chmod +x /usr/local/bin/xampp_setup.sh \
    && /usr/local/bin/xampp_setup.sh

# WORKDIR、ENTRYPOINT、CMDの順序がお作法
WORKDIR /opt/lampp/htdocs

EXPOSE 80 3306

COPY *.sed /root/
COPY init.sh /root/init.sh
CMD "/root/init.sh"
#CMD "/bin/sh"
