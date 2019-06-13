# -*- coding: utf-8 -*-
"""
Created on Sun Mar 17 00:52:41 2019

@author: User
"""

from textblob import TextBlob
from PyLyrics import *
from tinytag import TinyTag
import re
import pickle


def lyric_classify(track):
    
    #Setting song meta data
    path = 'D:/Music/English/'+track+'.mp3'
    tag = TinyTag.get(path)
    artist = tag.albumartist
    title = tag.title
    print('Results: ')
    print (artist,title)
    
    #Downloading song lyrics
    song = PyLyrics.getLyrics(artist,title)
    print(song)
#    
    score = 0;
    count = 0;
    total_pol = 0;
    lines = 0;
    
    mod_file = 'D:/Projects/FYP/Listener/lyric_model2.sav'
    lyric_model = pickle.load(open(mod_file, 'rb'))
    
    #Creating textblob for lyrics
    ly = TextBlob(song)
    print(ly.polarity)
    #classifying lyrics
    results = lyric_model.classify(song)
    print(results)
    
    
    for sentence in ly.sentences:
       # print(sentence)
        #print(sentence.words)
        
        #Polarity calculation
        p = sentence.polarity
        total_pol = total_pol + p
        lines = lines + 1
        if p<-0.5:
            score = score + p
            count = count + 1
            
    #Total Polarity
    print(total_pol)
    #Avg Polarity
    avg_pol = total_pol/lines
    print(avg_pol)
    print(score)
    #Avg Negativity
    #print(score/count)
    
    #data Array
    data = [results, avg_pol]
    
    return data

#def hello():
#    p = 'fish'
#    print('Working')
#    return p

#lyric_classify('Nine Inch Nails - Hurt')