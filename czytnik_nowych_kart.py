#!/usr/bin/env python
# -*- coding: utf8 -*-
import RPi.GPIO as GPIO
import MFRC522
import signal
import time
import MySQLdb
# Ustawienie pinów GPIO w celu obsługi diod LED
GPIO.setmode(GPIO.BOARD)
GPIO.setup(11, GPIO.OUT)
GPIO.setup(12, GPIO.OUT)
GPIO.setup(13, GPIO.OUT)
GPIO.output(12, 0)
GPIO.output(11, 1)
GPIO.output(13, 0)
odczyt = True
# Połączenie z bazą
connect = MySQLdb.connect("localhost", "user", "zpi", "zpi")
db = connect.cursor()
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
    # Pobranie ID karty.
    (status,uid) = Czytnik.MFRC522_Anticoll()
    if status == Czytnik.MI_OK:
		# Wyświetlenie ID karty.
		idkarty = str(uid[0])+str(uid[1])+str(uid[2])+str(uid[3])
		print "ID karty: "+idkarty
		# Obsługa bazy danych
		db.execute("SELECT IdKarty FROM Karty WHERE IdKarty='"+idkarty+"';")
		user = db.fetchone()
		uid = str(user)
		# Jeśli karta nie istnieje w bazie danych dopisuje ją do bazy,
		# po czym wydaje odpowiednie sygnały diodą oraz buzzerem
		if (uid == "None"):
			db.execute("INSERT INTO Karty(IdKarty) VALUES ("+idkarty+");")
			connect.commit()
			print "Dodano nową kartę"
			GPIO.output(11, 0)
			GPIO.output(12, 1)
			GPIO.output(13, 1)
			time.sleep(0.5)
			GPIO.output(13, 0)
			time.sleep(2)
			GPIO.output(13, 1)
			time.sleep(0.2)
			GPIO.output(13, 0)
			time.sleep(0.2)
			GPIO.output(13, 1)
			time.sleep(0.2)
			GPIO.output(13, 0)
		else:
			# Jeśli karta widnieje w bazie zostaje wysłany odpowiedni 
			# sygnał dźwiękowy oraz w dalszym ciągu pali się czerwony led. 
			print "Ta karta została wcześniej dodana"
			i = 0
			while i<5:
				i = i + 1	
				GPIO.output(13, 1)
				time.sleep(0.3)
				GPIO.output(13, 0)
				time.sleep(0.3) 			
        # Przywrócenie ledom stanu początkowego
		GPIO.output(11, 1)
		GPIO.output(12, 0)