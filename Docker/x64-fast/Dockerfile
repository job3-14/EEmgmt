FROM  ubuntu:18.04
ARG DEBIAN_FRONTEND=noninteractive #キーボード入力待ちをさせない

RUN sed -i".bak" -e 's/\/\/us.archive.ubuntu.com/\/\/ftp.jaist.ac.jp/g' /etc/apt/sources.list
RUN apt update
RUN apt upgrade -y

RUN apt install -y tzdata
#timezone
ENV TZ=Asia/Tokyo

RUN apt install -y python3-pip  python-pip  python3-tk fonts-noto  xrdp mate-desktop-environment-core mate-desktop-environment
RUN pip3 install netifaces mysql-connector-python slackweb
RUN pip install -U nfcpy
#RUN apt -y install mate-desktop-environment-core
#RUN apt -y install mate-desktop-environment
RUN service xrdp start

CMD service xrdp start
CMD rm /var/run/xrdp/xrdp.pid
CMD service xrdp restart && tail -f /dev/null