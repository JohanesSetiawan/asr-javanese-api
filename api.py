from flask import Flask, request, jsonify
from flask_cors import CORS
from huggingsound import SpeechRecognitionModel
from pyngrok import conf, ngrok

app = Flask(__name__)
CORS(app)

# Load the speech recognition model


@app.route('/transcribe', methods=['POST'])
def transcribe_audio():
    try:
        # Get the uploaded audio file from the request
        audio_file = request.files['audio']

        # Save the audio file temporarily
        audio_path = "./tmp/temp_audio.wav"
        audio_file.save(audio_path)

        model_cahya = SpeechRecognitionModel(
            "cahya/wav2vec2-large-xlsr-javanese")

        # Transcribe the audio
        transcription = model_cahya.transcribe([audio_path])[0]

        # Return the transcription as JSON
        return jsonify({'transcription': transcription})

    except Exception as e:
        return jsonify({'error': str(e)})


if __name__ == '__main__':
    port = "5000"
    conf.get_default().auth_token = "2YDHO8zwT4qHaWssmLn5dXfOH8E_5uGZ87pcLULCD7guPQKvr"
    public_url = ngrok.connect(port).public_url
    print(" * ngrok tunnel \"{}\" -> \"http://127.0.0.1:{}\"".format(public_url, port))
    app.run(debug=True)
