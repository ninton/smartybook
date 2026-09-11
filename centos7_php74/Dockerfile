FROM almalinux:8.10

# TimeZoneの設定
RUN echo 'ZONE="Asia/Tokyo"' > /etc/sysconfig/clock

RUN yum install -y net-tools
RUN yum install -y wget

RUN wget --version
RUN wget https://downloads.sourceforge.net/project/xampp/XAMPP%20Linux/7.4.11/xampp-linux-x64-7.4.11-0-installer.run
RUN chmod +x xampp-linux-x64-7.4.11-0-installer.run
RUN ./xampp-linux-x64-7.4.11-0-installer.run --version
RUN ./xampp-linux-x64-7.4.11-0-installer.run --enable-components xampp_developer_files --mode unattended


EXPOSE 80 3306

COPY *.sed /root/
COPY init.sh /root/init.sh
CMD "/root/init.sh"
#CMD "/bin/sh"
