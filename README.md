***製作中*** <br>
入退室管理システムです。<br>

***推奨動作環境***<br>
raspberrypi3b+<br>
ディスプレイ 1920*1080 または 1368*1024  または2048*1536<br>
タッチパネル<br>

***最低動作環境***<br>
ハードウェア(Raspberrypi3b+ , Raspbian Stretch with desktop)向けに設計<br>
ディスプレイ 800*600 (GUIが正しく表示されない可能性があります。)<br>

***環境構築***<br>
sudo apt install -y  git mariadb-server python3-pip  php7.0 apache2   python-pip  netatalk bridge-utils hostapd python3-tk fonts-noto fonts-noto ibus-mozc<br>
sudo pip3 install netifaces mysql-connector-python<br>
sudo pip install -U nfcpy<br>
#GUI環境のインストール <br>
sudo apt-get install --no-install-recommends xserver-xorg <br>
sudo apt-get install --no-install-recommends xinit <br>
sudo apt-get install raspberrypi-ui-mods <br>
#日本語環境のインストール <br>
#sudo apt install ibus-mozc <br>
#リモート環境のインストール <br>
sudo apt install xrdp <br>

#テスト
pip3 install PyAutoGUI