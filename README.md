# Automatic Speech Recognition for Javanese Language

## Introduction

Automatic Speech Recognition is a model deep learning to convert speech into text. This model is trained using the [OpenSLR](https://openslr.org/41) dataset. The dataset used is the Javanese language dataset. The dataset is divided into 2 parts, namely train, and validation. The dataset is trained using the `wav2vec2` based model from Facebook.

## How to use

### 1. Clone this repository

```bash
git clone https://github.com/JohanesSetiawan/asr-javanese-api.git
```

### 2. Install requirements

```bash
pip install Flask flask-cors huggingsound pyngrok
```

if you using server, and not the local machine.

or

```bash
pip install Flask flask-cors huggingsound
```

if you using local machine.

### 3. Run the server

```bash
python api.py
```

### 4. Open the link

Open the link that appears in the terminal. The link will be used to access the API.

### 5. Paste the link to the `index.html` file

Paste the link that appears in the terminal to the `index.html` file, in the:

```javascript
url: "<FLASK_API>/transcribe", // Flask server API endpoint variable.
```

### 6. Open the `index.html` file

### 7. Upload the audio file

### 8. Click the `Transcribe` button

### 9. Wait for the process to finish

### 10. The result will appear in the Transcription section

## References

[Javanese Model](https://huggingface.co/cahya/wav2vec2-large-xlsr-javanese)

[Base Model](https://huggingface.co/facebook/wav2vec2-large-xlsr-53)

[Training Code](https://github.com/cahya-wirawan/indonesian-speech-recognition/blob/main/XLSR_Wav2Vec2_for_Indonesian_Fine_Tuning-Javanese.ipynb)

##

You can use API in locally or using [Google Colab](https://colab.research.google.com/drive/1ODTygjwyYh68G4yKRkajItXgu7G8Xe3S?usp=sharing) to run API.

