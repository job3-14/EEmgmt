***製作中*** <br>
入退室管理システムです。<br>
Dcoer 版<br>

***Docker***<br>
このシステムは64bitのCPUで動作するDockerで動作します。<br>
Raspberry piはraspberrypi3以上で動作します。また標準のraspbianは32bitモードで動作するため対応していません。<br>
またこのシステムは本体からのGUI出力は対応していません。RDPをご利用ください。<br>


***推奨動作環境***<br>
raspberrypi3b+ (ARM64)<br>
os : snappy ubuntu core<br>
VERSION="18.04.2 LTS (Bionic Beaver)"<br>
タッチパネル<br>

***最低動作環境***<br>
ハードウェア ARM64,Unix,<br>
ディスプレイ 800x600 (GUIが正しく表示されない可能性があります。)<br>

***環境構築***<br>
docker-composeを利用<br>
各環境に合わせてdocker , docker-composeをインストールしてください。<br>

#***その他***
#mariadb:10.3.0
