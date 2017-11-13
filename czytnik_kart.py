#!/usr/bin/env python
# -*- coding: utf8 -*-

import RPi.GPIO as GPIO
import MFRC522
import signal
import time

# Ustawienie pinów GPIO w celu obsługi diod LED
GPIO.setmode(GPIO.BOARD)
GPIO.setup(11, GPIO.OUT)
GPIO.setup(12, GPIO.OUT)
GPIO.output(11, 1)
GPIO.output(12, 0)

odczyt = True

# Ustawienie input mode na pinach GPIO, gdy skrypt zostanie zakończony
def koniec(signal,frame):
    global odczyt
    print "Wciśnij Ctrl + C, by zakończyć."
    odczyt = False
    GPIO.cleanup()

# Wychwycenie sygnału zakończenia programu
signal.signal(signal.SIGINT, koniec)

# Utworzenie obiektu klasy MFRC522
Czytnik = MFRC522.MFRC522()

print "Przyłóż kartę do czytnika."
print "Kombinacja CTRL + C kończy działanie programu."

# W poniższej pętli odczytywany jest ID karty.
while odczyt:
    
    # Skanowanie w celu wykrycia karty 
    (status,TagType) = Czytnik.MFRC522_Request(Czytnik.PICC_REQIDL)

    if status == Czytnik.MI_OK:
		print "Wykryto kartę."
		GPIO.output(11, 0)
		GPIO.output(12, 1)
		
    # Pobranie ID karty.
    (status,uid) = Czytnik.MFRC522_Anticoll()

    # Wyświetlenie ID karty.
    if status == Czytnik.MI_OK:
		print "ID karty: "+str(uid[0])+str(uid[1])+str(uid[2])+str(uid[3])
		time.sleep(5)
		GPIO.output(11, 1)
		GPIO.output(12, 0)
