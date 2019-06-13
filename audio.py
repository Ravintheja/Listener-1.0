# -*- coding: utf-8 -*-
"""
Created on Wed Apr 17 15:03:42 2019

@author: User
"""
import sklearn
import librosa
import librosa.display
import numpy as np
import pickle


def audio_classify(name):        
    
    #filename = "D:/Music/Player/{}.wav".format(name)
    filename = "C:/xampp/htdocs/Listener/Player/{}.wav".format(name)
    print(filename)
    y, sr = librosa.load(filename)
    print("Begin")
    
    
    #**Tempo***********************************************************************
    tempo, beat_frames = librosa.beat.beat_track(y=y, sr=sr)
    print('Estimated tempo: Beats Per Minute')
    print(tempo)
    
    
    #**Zero Crossing Rate**********************************************************
    n0 = 9000
    n1 = 9100
    zero_crossings = librosa.zero_crossings(y[n0:n1], pad=False)
    print('Zero Crossing:')
    zero_cross = sum(zero_crossings)
    print(zero_cross)
    
    
    #**Spectral Centroid***********************************************************
    spectral_centroids = librosa.feature.spectral_centroid(y, sr=sr)[0]
    spectral_centroids.shape
    (775,)
    # Computing the time variable for visualization
    frames = range(len(spectral_centroids))
    t = librosa.frames_to_time(frames)
    # Normalising the spectral centroid for visualisation
    def normalize(x, axis=0):
        return sklearn.preprocessing.minmax_scale(x, axis=axis)
    print("Spectral Centroid")
    spec_cen = np.mean(spectral_centroids, axis=None)
    print(spec_cen)
    
    
    #**Spectral Rolloff************************************************************
    print('Spectral Rolloff:')
    spectral_rolloff = librosa.feature.spectral_rolloff(y+0.01, sr=sr)
    spec_roll = np.mean(spectral_rolloff)
    print(spec_roll)
    
    
    
    #**Mel-Frequency Cepstral Coefficients*****************************************
    print('Mel-Frequency:')
    y, fs = librosa.load(filename)
    mfccs = librosa.feature.mfcc(y, sr=fs)
    mel_freq = np.mean(mfccs)
    print(mel_freq)
    
    
    ##**Chroma Frequencies*********************************************************
    print('Chroma-Frequency:')
    hop_length = 512
    chromagram = librosa.feature.chroma_stft(y, sr=sr, hop_length=hop_length)
    chro_freq = np.mean(chromagram)
    print(chro_freq)
    
    #Classifying Song
    data = []
    data.append([1,1,1,1,1,1])
    data.append([2,2,2,2,2,2]) 
    
    data.append([tempo, zero_cross, spec_cen, spec_roll, mel_freq, chro_freq])
    
    mod_file = 'D:/Projects/FYP/Listener/song_models.sav'
    audio_model = pickle.load(open(mod_file, 'rb'))
    results = audio_model.predict(data)
    
    print(results[2])
    print(results)
    
    return results[2]
   
#lee = "Nine Inch Nails - Hurt"
#audio_classify(lee)