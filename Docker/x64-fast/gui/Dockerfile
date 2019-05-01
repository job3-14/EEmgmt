FROM  ubuntu:18.04

RUN sed -i".bak" -e 's/\/\/us.archive.ubuntu.com/\/\/ftp.jaist.ac.jp/g' /etc/apt/sources.list
RUN apt update

#TEST
ENV TZ=Asia/Tokyo
RUN apt install -y tzdata
#timezone
#ENV TZ=Asia/Tokyo

RUN apt-get install  -y --no-install-recommends ubuntu-mate-core^
RUN apt install -y git  python3-pip php7.0 apache2 python-pip  python3-tk fonts-noto ibus-mozc xrdp
RUN pip3 install netifaces mysql-connector-python slackweb
RUN pip install -U nfcpy
RUN service xrdp start

CMD service xrdp start
CMD rm /var/run/xrdp/xrdp.pid
CMD service xrdp restart && tail -f /dev/null
