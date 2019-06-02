#!/usr/bin/python
# coding:utf-8
import time
import RPi.GPIO as GPIO
import subprocess

def lcd():
    subprocess.check_output(["i2cset","-y","1","0x3e","0x00","0x38","0x39","0x14","0x70","0x56","0x6c","0x38","0x0C","0x01" ,"i"]) #初期化
    subprocess.check_output(["i2cset","-y","1","0x3e","0x40","0xbc","0xac","0xaf","0xc4","0xc0","0xde","0xb3","0xdd","i"])
    subprocess.check_output(["i2cset","-y","1","0x3e","0x00","0xC0","b"])
    subprocess.check_output(["i2cset","-y","1","0x3e","0x40","0xbc","0xcf","0xbd","i"])
    subprocess.check_output(["shutdown","-h","now"])

gpio_pin = 21
GPIO.setmode(GPIO.BCM)
GPIO.setup(gpio_pin,GPIO.IN,pull_up_down=GPIO.PUD_UP)

while True:
    GPIO.wait_for_edge(gpio_pin, GPIO.FALLING)
    i = 0

    for i in range(500):
        button_st = GPIO.input(gpio_pin)
        if button_st == 0:
            if i >= 499:
                try:
                    lcd()
                except:
                    pass
                break
        else:
                break
        time.sleep(0.01)
