#!/usr/bin/python
# coding:utf-8
import subprocess
import netifaces
import time

#初期化
subprocess.check_output(["i2cset","-y","1","0x3e","0x00","0x38","0x39","0x14","0x70","0x56","0x6c","0x38","0x0C","0x01" ,"i"])

def ipadress():                    #ipアドレス取得関数
	ip = netifaces.ifaddresses('eth0')[netifaces.AF_INET][0]['addr']
	return ip

for i in range(60):
	try:
		ipadress = ipadress()
		break
	except:
		time.sleep(10)


i2c = ["i2cset","-y","1","0x3e","0x40"]
i = 0
for ip in ipadress:
	i += 1
	if i==9:
		i2c += ["i"]
		subprocess.check_output(i2c)
		subprocess.check_output(["i2cset","-y","1","0x3e","0x00","0xC0","b"])
		i2c = ["i2cset","-y","1","0x3e","0x40"]

	if ip=="0":
		i2c +=["0x30"]
	elif ip=="1":
		i2c +=["0x31"]
	elif ip=="2":
		i2c +=["0x32"]
	elif ip=="3":
		i2c +=["0x33"]
	elif ip=="4":
		i2c +=["0x34"]
	elif ip=="5":
		i2c +=["0x35"]
	elif ip=="6":
		i2c +=["0x36"]
	elif ip=="7":
		i2c +=["0x37"]
	elif ip=="8":
		i2c +=["0x38"]
	elif ip=="9":
		i2c +=["0x39"]
	elif ip==".":
		i2c +=["0x2e"]

i2c += ["i"]
subprocess.check_output(i2c)
