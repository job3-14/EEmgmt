#!/usr/bin/python
# coding:utf-8
import time
import RPi.GPIO as GPIO
import subprocess

gpio_pin = 13
GPIO.setmode(GPIO.BCM)
GPIO.setup(gpio_pin,GPIO.IN,pull_up_down=GPIO.PUD_UP)

while True:
    GPIO.wait_for_edge(gpio_pin, GPIO.FALLING)
    i = 0

    for i in range(500):
        button_st = GPIO.input(gpio_pin)
        if button_st == 0:
            if i >= 499:
                subprocess.check_output(["sudo", "shutdown","-h","now"])
                break
        else:
                break
        time.sleep(0.01)
