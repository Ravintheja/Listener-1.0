# -*- coding: utf-8 -*-
"""
Created on Tue Apr 16 21:51:42 2019

@author: User
"""

import sys
import re
import csv
import pandas
import audio
import lyrics
import mysql.connector
import time
from apscheduler.schedulers.background import BackgroundScheduler

REFRESH_INTERVAL = 5 #seconds
scheduler = BackgroundScheduler()
scheduler.start()

running = False


def process(name, time):
    
    aud = audio.audio_classify(name)
    lyr = lyrics.lyric_classify(name)
    
#    print(aud)
#    print('*******')
#    print(lyr)
    
    data = [name,time, aud,lyr[0],lyr[1]]
    
    
    with open('C:/xampp/htdocs/Listener/test.csv', 'a') as csvFile:
        writer = csv.writer(csvFile)
        writer.writerow(data)
        csvFile.close()
    
    print('Done.........')
        
#def test (): #Testing only
#    filename = "C:\Users\User\Desktop\list2.csv"
#    names = ['title', 'time', 'audio', 'lyric', 'polarity']
#    history = pandas.read_csv(filename, names=names)
#    p = history['audio'].mode()
#    print p
#    c = history['lyric'].mode()
#    print c
#    a = history['polarity'].mean()
#    print a
  

def run():
    global running
    print("Go")
    if running == False:
        
        running = True
        mydb = mysql.connector.connect(
          host="localhost",
          user="root",
          passwd="",
          database="listener1"
        )
        mycursor = mydb.cursor()
        mycursor.execute("SELECT * FROM history WHERE checked = 0")
        myresult = mycursor.fetchall()
        
        for x in myresult:
          print(x)
          mycursor.execute("UPDATE history SET checked = 1 WHERE id = "+str(x[0]))
          mydb.commit()
          
          n = re.sub('.wav', r'', x[1])
          t = x[2]
          print(n)
          process(n,t)
        
        filename = "C:/xampp/htdocs/Listener/test.csv"
        names = ['title', 'time', 'audio', 'lyric', 'polarity']
        history = pandas.read_csv(filename, names=names)
        a = history['audio'].mode()
        print a
        l = history['lyric'].mode()
        print l
        p = history['polarity'].mean()
        print p
        mycursor.execute("UPDATE verdict SET audMood = '"+str(a[0])+"', lyrMood = '"+str(l[0])+"', pol = '"+str(p)+"' WHERE id = 0")
        mydb.commit()
    
        print('Round Complete')
        running = False

def start():
    scheduler.add_job(run, 'interval', seconds = REFRESH_INTERVAL)
    while True:
        time.sleep(1)
    
start()
#process(track_name, runtime)