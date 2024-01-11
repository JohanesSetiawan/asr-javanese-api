<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jawa Automatic Speech Recognition | JAWIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<style>
    .icon-list {
        padding-left: 0;
        list-style: none;
    }

    .icon-list li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 0.25rem;
    }

    .icon-list li::before {
        display: block;
        flex-shrink: 0;
        width: 1.5em;
        height: 1.5em;
        margin-right: 0.5rem;
        content: "";
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    .textJustify {
        text-align: justify;
        text-justify: inter-word;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    .box {
        outline: 2px dashed white;
        height: 300px;
        border-radius: 10px;
    }

    .box.is-dragover {
        background-color: grey;
    }

    .box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .box label strong {
        text-decoration: underline;
        color: #0d6efd;
        cursor: pointer;
    }

    .box label strong:hover {
        color: blueviolet
    }

    .box input {
        display: none;
    }
</style>

<body>
    <div class="col-lg-8 mx-auto p-3 py-md-5">
        <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
            <h1 class="text-light">Jawa Automatic Speech Recognition | JAWIR</h1>
        </header>

        <main>
            <div class="row g-5">
                <div class="col-md-6">
                    <div class="show-alert"></div>
                    <h2>Transcribe</h2>
                    <div class="box my-5">
                        <label>
                            <strong>Choose a file</strong>
                            <span>or drag it here.</span>
                            <input class="box__file form-control" type="file" name="file" id='audioInput' />
                        </label>
                        <div class="file-list"></div>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-lg mb-3" onclick="transcribe()">Transcribe</button>
                    </div>
                    <div class="my-3">
                        <p><b>Preview Audio:</b></p>
                        <audio class="my-3 mb-5" controls></audio>
                    </div>

                    <div class="mb-5">
                        <h2>Kembali ke home</h2>
                        <button class="btn btn-primary btn-lg px-4 mt-2" onclick="backToIndex()">Back</button>
                    </div>


                </div>

                <div class="col-md-6">
                    <h2>Hasil Transcribe</h2>
                    <div id="result" class="my-3"></div>
                </div>
            </div>
        </main>
        <footer class="pt-5 my-5 text-muted border-top">
            Created by Kelompok 2 - STKI &middot; &copy; 2024
        </footer>

    </div>
    <script>
        function backToIndex() {
            window.location.href = './index.php';
        }

        const box = document.querySelector('.box');
        const fileInput = document.querySelector('[name="file"]');
        const selectButton = document.querySelector('label strong');
        const fileList = document.querySelector('.file-list');
        const showAlert = document.querySelector('.show-alert');

        let droppedFiles = [];

        ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(event => box.addEventListener(event, function(e) {
            e.preventDefault();
            e.stopPropagation();
        }), false);

        ['dragover', 'dragenter'].forEach(event => box.addEventListener(event, function(e) {
            box.classList.add('is-dragover');
        }), false);

        ['dragleave', 'dragend', 'drop'].forEach(event => box.addEventListener(event, function(e) {
            box.classList.remove('is-dragover');
        }), false);

        box.addEventListener('drop', function(e) {
            droppedFiles = e.dataTransfer.files;
            fileInput.files = droppedFiles;
            updateFileList();
        }, false);

        fileInput.addEventListener('change', updateFileList);

        function updateFileList() {
            const file = fileInput.files[0];
            if (file) {
                fileList.innerHTML = `<p>Selected file: ${file.name}</p>`;
            } else {
                fileList.innerHTML = '';
            }
        }

        function transcribe() {
            var audioInput = document.getElementById("audioInput");
            var file = audioInput.files[0];

            if (!file) {
                alert("Please select an audio file.");
                return;
            }

            var formData = new FormData();
            formData.append("audio", file);

            var audioElement = document.querySelector("audio");
            audioElement.src = URL.createObjectURL(file);

            $.ajax({
                url: "https://4cf6-34-23-100-179.ngrok-free.app/transcribe", // Flask server API endpoint
                type: "POST", // HTTP method
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    updateAlert()
                    $("#result").text("Transcription: " + data.transcription.transcription); // Display transcription
                },
                error: function(error) {
                    alert("Error transcribing audio.");
                    updateAlertError()
                },
            });
        }

        function updateAlert() {
            const file = fileInput.files[0];
            if (file) {
                showAlert.innerHTML = `<div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Upload successful! You just uploaded this file: ${file.name}<br>
                <div>
                `;
            } else {
                showAlert.innerHTML = '';
            }
        }

        function updateAlertError() {
            showAlert.innerHTML = `<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Upload failed! file: ${file.name}<br>
                <div>
                `;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>