***製作中*** <br>
入退室管理システムです。<br>
Dcoer

***推奨動作環境***<br>
raspberrypi3b+<br>
ディスプレイ 1920x1080 または 1368x1024  または2048x1536<br>
タッチパネル<br>

***最低動作環境***<br>
ハードウェア(Raspberrypi3b+ , Raspbian Stretch with desktop)向けに設計<br>
ディスプレイ 800x600 (GUIが正しく表示されない可能性があります。)<br>

***環境構築***<br>
sudo apt install -y  git mariadb-server python3-pip  php7.0 apache2   python-pip  netatalk  python3-tk  fonts-noto ibus-mozc<br>
sudo pip3 install netifaces mysql-connector-python slackweb<br>
sudo pip install -U nfcpy<br>
#リモート環境のインストール <br>
sudo apt install xrdp <br>

***raspbian以外で動かす場合***
aplay--->GUI認証完了音に利用


***その他***
mariadb:10.3.0
