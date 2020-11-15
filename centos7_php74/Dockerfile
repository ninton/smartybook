FROM centos:7
MAINTAINER aoki_makoto@ninton.co.jp

# TimeZoneの設定
RUN echo 'ZONE"=Asia/Tokyo"' > /etc/sysconfig/clock

RUN yum install -y net-tools
RUN yum install -y wget

RUN wget --version
RUN wget "https://jaist.dl.sourceforge.net/project/xampp/XAMPP%20Linux/7.4.11/xampp-linux-x64-7.4.11-0-installer.run"
RUN chmod +x xampp-linux-x64-7.4.11-0-installer.run
RUN ./xampp-linux-x64-7.4.11-0-installer.run --version
RUN ./xampp-linux-x64-7.4.11-0-installer.run --enable-components xampp_developer_files --mode unattended


EXPOSE 80 3306

CMD "/bin/sh"
