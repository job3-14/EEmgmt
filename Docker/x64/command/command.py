#-*- coding:utf-8 -*-
import os
import subprocess
import time
path = "/opt/docker/command/file/signalfile.py"  #ファイルパス指定

if os.path.exists(path):  #ファイルが存在した場合削除
    os.remove(path)

while True:
    if os.path.exists(path):
        from file import signalfile  #ファイル読み込み
        if signalfile.command == "Shutdown":
            time.sleep(5)
            subprocess.check_output(["shutdown","-h","now"])
        elif signalfile.command == "Reboot":
            subprocess.check_output(["reboot"])
            time.sleep(5)
        else:
            os.remove(path)
    time.sleep(1)
